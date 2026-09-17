<?php
declare(strict_types=1);

/*
 * Lightweight, dependency-free certificate PDF generator.
 *
 * It uses built-in PDF fonts and embeds the EAC crest from images/eac-crest.png
 * as a translucent watermark. No external PDF package is required.
 */

function eac_certificate_pdf_latin(string $value): string
{
    $value = str_replace(["\r", "\n"], ' ', trim($value));
    if (function_exists('iconv')) {
        $converted = @iconv('UTF-8', 'Windows-1252//TRANSLIT//IGNORE', $value);
        if ($converted !== false) $value = $converted;
    }
    return $value;
}

function eac_certificate_pdf_escape(string $value): string
{
    return str_replace(
        ['\\', '(', ')'],
        ['\\\\', '\\(', '\\)'],
        eac_certificate_pdf_latin($value)
    );
}

function eac_certificate_pdf_text_width(string $value, float $size, float $factor = 0.52): float
{
    return strlen(eac_certificate_pdf_latin($value)) * $size * $factor;
}

function eac_certificate_pdf_text(
    string $font,
    float $size,
    float $x,
    float $y,
    string $value,
    array $colour = [0.10, 0.10, 0.10]
): string {
    return sprintf(
        "%.3F %.3F %.3F rg\nBT /%s %.2F Tf 1 0 0 1 %.2F %.2F Tm (%s) Tj ET\n",
        (float)$colour[0],
        (float)$colour[1],
        (float)$colour[2],
        $font,
        $size,
        $x,
        $y,
        eac_certificate_pdf_escape($value)
    );
}

function eac_certificate_pdf_centered_text(
    string $font,
    float $size,
    float $pageWidth,
    float $y,
    string $value,
    array $colour = [0.10, 0.10, 0.10],
    float $factor = 0.52
): string {
    $x = max(28.0, ($pageWidth - eac_certificate_pdf_text_width($value, $size, $factor)) / 2);
    return eac_certificate_pdf_text($font, $size, $x, $y, $value, $colour);
}

function eac_certificate_pdf_wrap(string $value, float $size, float $maxWidth, float $factor = 0.52): array
{
    $words = preg_split('/\s+/', trim($value)) ?: [];
    $lines = [];
    $line = '';
    foreach ($words as $word) {
        $candidate = $line === '' ? $word : $line . ' ' . $word;
        if ($line !== '' && eac_certificate_pdf_text_width($candidate, $size, $factor) > $maxWidth) {
            $lines[] = $line;
            $line = $word;
        } else {
            $line = $candidate;
        }
    }
    if ($line !== '') $lines[] = $line;
    return $lines ?: [''];
}

function eac_certificate_pdf_paeth(int $left, int $up, int $upLeft): int
{
    $estimate = $left + $up - $upLeft;
    $leftDistance = abs($estimate - $left);
    $upDistance = abs($estimate - $up);
    $cornerDistance = abs($estimate - $upLeft);
    if ($leftDistance <= $upDistance && $leftDistance <= $cornerDistance) return $left;
    if ($upDistance <= $cornerDistance) return $up;
    return $upLeft;
}

function eac_certificate_pdf_logo(string $filename = 'eac-crest.png'): ?array
{
    static $logos = [];
    static $loaded = [];
    if (!empty($loaded[$filename])) return $logos[$filename] ?? null;
    $loaded[$filename] = true;

    if (!function_exists('gzuncompress') || !function_exists('gzcompress')) return null;
    $path = __DIR__ . '/../images/' . basename($filename);
    $png = is_file($path) ? @file_get_contents($path) : false;
    if (!is_string($png) || !str_starts_with($png, "\x89PNG\r\n\x1A\n")) return null;

    $offset = 8;
    $header = null;
    $palette = '';
    $transparency = '';
    $imageData = '';
    $length = strlen($png);
    while ($offset + 12 <= $length) {
        $chunkLength = unpack('Nlength', substr($png, $offset, 4));
        $chunkLength = (int)($chunkLength['length'] ?? -1);
        if ($chunkLength < 0 || $offset + 12 + $chunkLength > $length) return null;
        $type = substr($png, $offset + 4, 4);
        $chunk = substr($png, $offset + 8, $chunkLength);
        $offset += 12 + $chunkLength;

        if ($type === 'IHDR') {
            $header = unpack(
                'Nwidth/Nheight/CbitDepth/CcolourType/Ccompression/Cfilter/Cinterlace',
                $chunk
            );
        } elseif ($type === 'PLTE') {
            $palette = $chunk;
        } elseif ($type === 'tRNS') {
            $transparency = $chunk;
        } elseif ($type === 'IDAT') {
            $imageData .= $chunk;
        } elseif ($type === 'IEND') {
            break;
        }
    }

    if (!$header || $imageData === '') return null;
    $width = (int)($header['width'] ?? 0);
    $height = (int)($header['height'] ?? 0);
    $bitDepth = (int)($header['bitDepth'] ?? 0);
    $colourType = (int)($header['colourType'] ?? -1);
    $interlace = (int)($header['interlace'] ?? 1);
    if ($width < 1 || $height < 1 || $bitDepth !== 8 || $interlace !== 0) return null;
    if (!in_array($colourType, [2, 3, 6], true)) return null;

    $bytesPerPixel = $colourType === 6 ? 4 : ($colourType === 2 ? 3 : 1);
    $rowLength = $width * $bytesPerPixel;
    $inflated = @gzuncompress($imageData);
    if ($inflated === false && function_exists('zlib_decode')) $inflated = @zlib_decode($imageData);
    if (!is_string($inflated) || strlen($inflated) < ($rowLength + 1) * $height) return null;

    $position = 0;
    $previous = array_fill(0, $rowLength, 0);
    $rgb = '';
    $alpha = '';
    for ($rowNumber = 0; $rowNumber < $height; $rowNumber++) {
        $filter = ord($inflated[$position++]);
        $row = [];
        for ($index = 0; $index < $rowLength; $index++) {
            $raw = ord($inflated[$position++]);
            $left = $index >= $bytesPerPixel ? $row[$index - $bytesPerPixel] : 0;
            $up = $previous[$index] ?? 0;
            $upLeft = $index >= $bytesPerPixel ? ($previous[$index - $bytesPerPixel] ?? 0) : 0;
            $prediction = match ($filter) {
                0 => 0,
                1 => $left,
                2 => $up,
                3 => intdiv($left + $up, 2),
                4 => eac_certificate_pdf_paeth($left, $up, $upLeft),
                default => -1,
            };
            if ($prediction < 0) return null;
            $row[$index] = ($raw + $prediction) & 255;
        }

        for ($column = 0; $column < $width; $column++) {
            if ($colourType === 6) {
                $base = $column * 4;
                $rgb .= chr($row[$base]) . chr($row[$base + 1]) . chr($row[$base + 2]);
                $alpha .= chr($row[$base + 3]);
            } elseif ($colourType === 2) {
                $base = $column * 3;
                $rgb .= chr($row[$base]) . chr($row[$base + 1]) . chr($row[$base + 2]);
                $alpha .= chr(255);
            } else {
                $paletteIndex = $row[$column];
                $paletteBase = $paletteIndex * 3;
                if ($paletteBase + 2 >= strlen($palette)) return null;
                $rgb .= $palette[$paletteBase] . $palette[$paletteBase + 1] . $palette[$paletteBase + 2];
                $alpha .= $paletteIndex < strlen($transparency) ? $transparency[$paletteIndex] : chr(255);
            }
        }
        $previous = $row;
    }

    $compressedRgb = @gzcompress($rgb, 9);
    $compressedAlpha = @gzcompress($alpha, 9);
    if (!is_string($compressedRgb) || !is_string($compressedAlpha)) return null;
    $logo = [
        'width' => $width,
        'height' => $height,
        'rgb' => $compressedRgb,
        'alpha' => $compressedAlpha,
    ];
    $logos[$filename] = $logo;
    return $logo;
}

function eac_certificate_pdf_date(string $issuedAt): string
{
    try {
        return (new DateTimeImmutable($issuedAt))->format('j F Y');
    } catch (Throwable) {
        return $issuedAt;
    }
}

function eac_build_certificate_pdf(array $certificate): string
{
    $pageWidth = 841.89;
    $pageHeight = 595.28;
    $fullName = trim((string)($certificate['fullName'] ?? 'Participant'));
    $courseName = trim((string)($certificate['courseName'] ?? 'EAC Statistics e-Learning Course'));
    $certificateNumber = trim((string)($certificate['certificateNumber'] ?? ''));
    $issuedAt = eac_certificate_pdf_date((string)($certificate['issuedAt'] ?? date('Y-m-d')));
    $verificationUrl = trim((string)($certificate['verificationUrl'] ?? ''));
    $logo = eac_certificate_pdf_logo('eac-crest.png');
    // The achievement seal is drawn below as PDF vector artwork so its wording
    // is always exact and never depends on AI-generated raster lettering.
    $seal = null;

    $content = '';
    $content .= "1 1 1 rg 0 0 841.89 595.28 re f\n";

    // Formal EAC frame and four-colour edge accents.
    $content .= "0.000 0.520 0.220 RG 7 w 12 12 817.89 571.28 re S\n";
    $content .= "0.000 0.420 0.690 RG 1.5 w 22 22 797.89 551.28 re S\n";
    $content .= "0.000 0.520 0.220 rg 12 573 500 7 re f\n";
    $content .= "1.000 0.820 0.000 rg 512 573 100 7 re f\n";
    $content .= "0.820 0.000 0.090 rg 612 573 100 7 re f\n";
    $content .= "0.000 0.570 0.760 rg 712 573 118 7 re f\n";
    $content .= "0.000 0.520 0.220 rg 12 15 500 7 re f\n";
    $content .= "1.000 0.820 0.000 rg 512 15 100 7 re f\n";
    $content .= "0.820 0.000 0.090 rg 612 15 100 7 re f\n";
    $content .= "0.000 0.570 0.760 rg 712 15 118 7 re f\n";

    if ($logo) {
        $logoWidth = 74.0;
        $logoHeight = $logoWidth * ((float)$logo['height'] / (float)$logo['width']);
        $logoX = ($pageWidth - $logoWidth) / 2;
        $logoY = 495.0;
        $content .= "q\n";
        $content .= sprintf("%.2F 0 0 %.2F %.2F %.2F cm\n/Im1 Do\nQ\n", $logoWidth, $logoHeight, $logoX, $logoY);
    }
    // Gold achievement seal centred between the date and signature blocks.
    $content .= "0.84 0.52 0.00 rg 0.40 0.22 0.00 RG 2 w 421 181 m 445.30 181 465 161.30 465 137 c 465 112.70 445.30 93 421 93 c 396.70 93 377 112.70 377 137 c 377 161.30 396.70 181 421 181 c f S\n";
    $content .= "0.98 0.73 0.08 rg 0.45 0.25 0.00 RG 1.4 w 421 174 m 441.43 174 458 157.43 458 137 c 458 116.57 441.43 100 421 100 c 400.57 100 384 116.57 384 137 c 384 157.43 400.57 174 421 174 c f S\n";
    $content .= "0.86 0.54 0.02 rg 0.45 0.25 0.00 RG 1 w 421 166 m 437.01 166 450 153.01 450 137 c 450 120.99 437.01 108 421 108 c 404.99 108 392 120.99 392 137 c 392 153.01 404.99 166 421 166 c f S\n";
    $content .= "1.00 0.84 0.25 rg 0.42 0.23 0.00 RG 1.2 w 421 160 m 427 144 l 445 144 l 431 134 l 436 117 l 421 127 l 406 117 l 411 134 l 397 144 l 415 144 l h f S\n";
    $content .= eac_certificate_pdf_centered_text('F2', 6.2, $pageWidth, 166, 'EAST AFRICAN COMMUNITY', [0.16, 0.09, 0.00], 0.52);
    $content .= eac_certificate_pdf_centered_text('F2', 5.5, $pageWidth, 103, 'EXCELLENCE - HONOUR - ACHIEVEMENT', [0.16, 0.09, 0.00], 0.52);

    $blue = [0.02, 0.25, 0.48];
    $content .= eac_certificate_pdf_centered_text('F1', 17, $pageWidth, 472, 'EAST AFRICAN COMMUNITY', $blue, 0.54);
    $content .= eac_certificate_pdf_centered_text('F3', 32, $pageWidth, 432, 'Certificate of Completion', [0.04, 0.04, 0.04], 0.48);
    // Four-colour EAC accent rule beneath the title.
    $content .= "0.000 0.520 0.220 RG 2.5 w 230 414 m 350 414 l S\n";
    $content .= "1.000 0.820 0.000 RG 2.5 w 350 414 m 410 414 l S\n";
    $content .= "0.820 0.000 0.090 RG 2.5 w 410 414 m 470 414 l S\n";
    $content .= "0.000 0.570 0.760 RG 2.5 w 470 414 m 612 414 l S\n";

    $content .= eac_certificate_pdf_centered_text('F3', 14, $pageWidth, 382, 'This is to certify that', $blue, 0.48);
    $nameSize = strlen(eac_certificate_pdf_latin($fullName)) > 36 ? 28 : (strlen(eac_certificate_pdf_latin($fullName)) > 26 ? 33 : 39);
    $content .= eac_certificate_pdf_centered_text('F4', $nameSize, $pageWidth, 335, strtoupper($fullName), $blue, 0.45);
    $content .= eac_certificate_pdf_centered_text('F3', 14, $pageWidth, 296, 'has successfully completed the online course on', $blue, 0.48);

    $courseLines = eac_certificate_pdf_wrap($courseName, 21, 650, 0.52);
    $courseY = count($courseLines) > 1 ? 264 : 268;
    foreach ($courseLines as $line) {
        $content .= eac_certificate_pdf_centered_text('F2', 21, $pageWidth, $courseY, $line, [0.04, 0.04, 0.04], 0.52);
        $courseY -= 24;
    }
    $content .= eac_certificate_pdf_centered_text('F3', 13, $pageWidth, 222, 'offered under the EAC Statistics E-Learning Programme', $blue, 0.48);

    $content .= eac_certificate_pdf_text('F3', 12, 105, 151, 'Issued ' . $issuedAt, [0.08, 0.08, 0.08]);
    $content .= "0.000 0.420 0.690 RG 1 w 78 136 m 295 136 l S\n";
    $content .= eac_certificate_pdf_centered_text('F3', 12, 186, 118, 'Date', $blue, 0.48);
    $content .= eac_certificate_pdf_text('F3', 12, 627, 151, 'East African Community', [0.08, 0.08, 0.08]);
    $content .= "0.000 0.420 0.690 RG 1 w 548 136 m 765 136 l S\n";
    $content .= eac_certificate_pdf_text('F3', 12, 633, 118, 'Secretary', $blue);
    $content .= eac_certificate_pdf_centered_text('F3', 11, $pageWidth, 67, 'Certificate ID: ' . $certificateNumber, $blue, 0.48);
    if ($verificationUrl !== '') {
        $content .= eac_certificate_pdf_centered_text('F1', 6.5, $pageWidth, 43, $verificationUrl, [0.35, 0.35, 0.35], 0.50);
    }

    $objects = [];
    $objects[1] = '<< /Type /Catalog /Pages 2 0 R >>';
    $objects[2] = '<< /Type /Pages /Kids [3 0 R] /Count 1 >>';
    $resources = '<< /Font << /F1 4 0 R /F2 5 0 R /F3 6 0 R /F4 7 0 R >>';
    $xObjects = [];
    if ($logo) $xObjects[] = '/Im1 9 0 R';
    if ($seal) $xObjects[] = '/Im2 13 0 R';
    if ($xObjects) $resources .= ' /XObject << ' . implode(' ', $xObjects) . ' >>';
    $resources .= ' >>';
    $objects[3] = sprintf(
        '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 %.2F %.2F] /Resources %s /Contents 10 0 R >>',
        $pageWidth,
        $pageHeight,
        $resources
    );
    $objects[4] = '<< /Type /Font /Subtype /Type1 /BaseFont /Times-Roman >>';
    $objects[5] = '<< /Type /Font /Subtype /Type1 /BaseFont /Times-Bold >>';
    $objects[6] = '<< /Type /Font /Subtype /Type1 /BaseFont /Times-Italic >>';
    $objects[7] = '<< /Type /Font /Subtype /Type1 /BaseFont /ZapfChancery-MediumItalic >>';

    if ($logo) {
        $objects[8] = '<< /Type /XObject /Subtype /Image /Width ' . (int)$logo['width'] .
            ' /Height ' . (int)$logo['height'] .
            ' /ColorSpace /DeviceGray /BitsPerComponent 8 /Filter /FlateDecode /Length ' .
            strlen((string)$logo['alpha']) . " >>\nstream\n" . $logo['alpha'] . "\nendstream";
        $objects[9] = '<< /Type /XObject /Subtype /Image /Width ' . (int)$logo['width'] .
            ' /Height ' . (int)$logo['height'] .
            ' /ColorSpace /DeviceRGB /BitsPerComponent 8 /Filter /FlateDecode /SMask 8 0 R /Length ' .
            strlen((string)$logo['rgb']) . " >>\nstream\n" . $logo['rgb'] . "\nendstream";
    } else {
        $objects[8] = '<< >>';
        $objects[9] = '<< >>';
    }

    $objects[10] = '<< /Length ' . strlen($content) . ">>\nstream\n" . $content . "endstream";
    $objects[11] = '<< /Title (' . eac_certificate_pdf_escape('EAC Certificate ' . $certificateNumber) .
        ') /Author (East African Community) /Creator (EAC Statistics e-Learning) >>';
    if ($seal) {
        $objects[12] = '<< /Type /XObject /Subtype /Image /Width ' . (int)$seal['width'] .
            ' /Height ' . (int)$seal['height'] .
            ' /ColorSpace /DeviceGray /BitsPerComponent 8 /Filter /FlateDecode /Length ' .
            strlen((string)$seal['alpha']) . ">>\nstream\n" . $seal['alpha'] . "\nendstream";
        $objects[13] = '<< /Type /XObject /Subtype /Image /Width ' . (int)$seal['width'] .
            ' /Height ' . (int)$seal['height'] .
            ' /ColorSpace /DeviceRGB /BitsPerComponent 8 /Filter /FlateDecode /SMask 12 0 R /Length ' .
            strlen((string)$seal['rgb']) . ">>\nstream\n" . $seal['rgb'] . "\nendstream";
    } else {
        $objects[12] = '<< >>';
        $objects[13] = '<< >>';
    }

    $pdf = "%PDF-1.4\n%\xE2\xE3\xCF\xD3\n";
    $offsets = [0];
    for ($id = 1; $id <= 13; $id++) {
        $offsets[$id] = strlen($pdf);
        $pdf .= $id . " 0 obj\n" . $objects[$id] . "\nendobj\n";
    }
    $xrefOffset = strlen($pdf);
    $pdf .= "xref\n0 14\n0000000000 65535 f \n";
    for ($id = 1; $id <= 13; $id++) {
        $pdf .= sprintf('%010d 00000 n ' . "\n", $offsets[$id]);
    }
    $pdf .= "trailer\n<< /Size 14 /Root 1 0 R /Info 11 0 R >>\nstartxref\n" . $xrefOffset . "\n%%EOF";
    return $pdf;
}
