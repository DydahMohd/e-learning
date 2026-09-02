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

/** Return the rendered width of text in PDF's built-in Times-Bold font. */
function eac_certificate_pdf_times_bold_width(string $value, float $size): float
{
    $widths = [
        ' '=>250, 'A'=>722, 'B'=>667, 'C'=>722, 'D'=>722, 'E'=>611, 'F'=>556,
        'G'=>778, 'H'=>778, 'I'=>389, 'J'=>500, 'K'=>778, 'L'=>667, 'M'=>944,
        'N'=>722, 'O'=>778, 'P'=>611, 'Q'=>778, 'R'=>722, 'S'=>556, 'T'=>667,
        'U'=>722, 'V'=>722, 'W'=>1000, 'X'=>722, 'Y'=>722, 'Z'=>667,
        'a'=>500, 'b'=>556, 'c'=>444, 'd'=>556, 'e'=>444, 'f'=>333, 'g'=>500,
        'h'=>556, 'i'=>278, 'j'=>333, 'k'=>556, 'l'=>278, 'm'=>833, 'n'=>556,
        'o'=>500, 'p'=>556, 'q'=>556, 'r'=>444, 's'=>389, 't'=>333, 'u'=>556,
        'v'=>500, 'w'=>722, 'x'=>500, 'y'=>500, 'z'=>444,
        '-'=>333, "'"=>278, '.'=>250,
    ];
    $latin = eac_certificate_pdf_latin($value);
    $units = 0;
    for ($index = 0, $length = strlen($latin); $index < $length; $index++) {
        $units += $widths[$latin[$index]] ?? 500;
    }
    return ($units / 1000) * $size;
}

function eac_certificate_pdf_centered_name(string $value, float $pageWidth, float $y, array $colour): string
{
    $name = strtoupper(trim($value) !== '' ? $value : 'Participant');
    $size = 39.0;
    $maxWidth = 720.0;
    $width = eac_certificate_pdf_times_bold_width($name, $size);
    if ($width > $maxWidth) {
        $size = max(24.0, $size * ($maxWidth / $width));
        $width = eac_certificate_pdf_times_bold_width($name, $size);
    }
    $x = ($pageWidth - $width) / 2.0;
    return eac_certificate_pdf_text('F2', $size, $x, $y, $name, $colour);
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
    $safeValue = trim((string)$value) !== '' ? $value : ' ';
    $textWidth = eac_certificate_pdf_text_width($safeValue, $size, $factor);
    $x = ($pageWidth - $textWidth) / 2.0;
    $x = max(28.0, $x);
    return eac_certificate_pdf_text($font, $size, $x, $y, $safeValue, $colour);
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

/** Build one continuous curved wordmark row like the SVG preview watermark. */
function eac_certificate_pdf_wave_wordmark(float $startX, float $endX, float $baseline, int $rowIndex): string
{
    $phrase = 'EAST AFRICAN COMMUNITY   ';
    $fontSize = 6.2;
    $advance = 3.55;
    $amplitude = 5.0;
    $wavelength = 180.0;
    $phase = ($rowIndex % 2) * M_PI;
    $colour = $rowIndex % 2 === 0 ? '0.895 0.925 0.950' : '0.900 0.945 0.920';
    $content = '';
    $phraseLength = strlen($phrase);
    $characterIndex = 0;

    for ($x = $startX; $x <= $endX; $x += $advance, $characterIndex++) {
        $character = $phrase[$characterIndex % $phraseLength];
        if ($character === ' ') continue;
        $position = (($x - $startX) / $wavelength) * (2 * M_PI) + $phase;
        $y = $baseline + ($amplitude * sin($position));
        $slope = ($amplitude * 2 * M_PI / $wavelength) * cos($position);
        $angle = atan($slope);
        $cosine = cos($angle);
        $sine = sin($angle);
        $content .= sprintf(
            "%s rg\nBT /F1 %.2F Tf %.4F %.4F %.4F %.4F %.2F %.2F Tm (%s) Tj ET\n",
            $colour, $fontSize, $cosine, $sine, -$sine, $cosine, $x, $y,
            eac_certificate_pdf_escape($character)
        );
    }
    return $content;
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
    $seal = eac_certificate_pdf_logo('certificate-gold-seal-v2.png');

    $content = '';
    $content .= "1 1 1 rg 0 0 841.89 595.28 re f\n";

    // Continuous blue/green wordmark waves matching the browser preview.
    foreach (range(45, 555, 32) as $rowIndex => $waveY) {
        $content .= eac_certificate_pdf_wave_wordmark(28.0, $pageWidth - 28.0, (float)$waveY, $rowIndex);
    }

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
    if ($seal) {
        $sealWidth = 96.0;
        $sealHeight = $sealWidth * ((float)$seal['height'] / (float)$seal['width']);
        $sealX = ($pageWidth - $sealWidth) / 2;
        $sealY = 89.0;
        $content .= "q\n";
        $content .= sprintf("%.2F 0 0 %.2F %.2F %.2F cm\n/Im2 Do\nQ\n", $sealWidth, $sealHeight, $sealX, $sealY);
    }

    $blue = [0.02, 0.25, 0.48];
    $content .= eac_certificate_pdf_centered_text('F1', 17, $pageWidth, 472, 'EAST AFRICAN COMMUNITY', $blue, 0.54);
    $content .= eac_certificate_pdf_centered_text('F2', 32, $pageWidth, 432, 'Certificate of Completion', [0.04, 0.04, 0.04], 0.48);
    // A precisely centred four-colour EAC accent rule beneath the title.
    $ruleWidth = eac_certificate_pdf_times_bold_width('Certificate of Completion', 32.0);
    $ruleStart = ($pageWidth - $ruleWidth) / 2.0;
    $rulePart = $ruleWidth / 4.0;
    $ruleColours = ['0.000 0.520 0.220', '1.000 0.820 0.000', '0.820 0.000 0.090', '0.000 0.570 0.760'];
    foreach ($ruleColours as $ruleIndex => $ruleColour) {
        $x1 = $ruleStart + ($rulePart * $ruleIndex);
        $x2 = $x1 + $rulePart;
        $content .= sprintf("%s RG 2.5 w %.2F 414 m %.2F 414 l S\n", $ruleColour, $x1, $x2);
    }

    $content .= eac_certificate_pdf_centered_text('F3', 14, $pageWidth, 382, 'This is to certify that', $blue, 0.48);
    $content .= eac_certificate_pdf_centered_name($fullName, $pageWidth, 335, $blue);
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
