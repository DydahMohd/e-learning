<?php
declare(strict_types=1);
?>
<?php if ($needsAssessmentScreen): ?>
<section class="screen" id="screen-assessment">
    <div class="assess-head"><div class="wrap"><h2>Final Assessment</h2><p>Complete all modules, then answer the database-managed assessment questions.</p></div></div>
    <div class="assess-body"><div class="wrap">
        <div class="test-progress"><div class="tp-row"><div class="tp-bar"><div class="tp-fill" id="tpFill"></div></div><span class="assess-timer" id="assessTimer">--:--</span></div><div class="tp-txt" id="tpTxt">0 answered</div></div>
        <div id="testQs"></div>
        <div class="test-submit"><button class="btn btn-green btn-lg" id="submitTest">Submit &amp; see my result</button></div>
        <div id="testResult"></div>
    </div></div>
</section>
<?php endif; ?>
<?php if ($needsCertificateScreen): ?>
<section class="screen" id="screen-certificate">
    <div class="cert-wrap">
        <div class="cert-actions">
            <button class="btn btn-green" id="certPng">Download certificate (PDF)</button>
            <button class="btn btn-ghost" id="certPrint">Print / Save as PDF</button>
            <button class="btn btn-ghost" data-screen="hub">Back to modules</button>
        </div>
        <div class="cert-stage">
            <svg id="certSVG" viewBox="0 0 1000 707" xmlns="http://www.w3.org/2000/svg" font-family="Georgia, 'Times New Roman', serif">
                <rect width="1000" height="707" fill="#fff"/>
                <rect x="16" y="16" width="968" height="675" fill="none" stroke="#00843d" stroke-width="6"/>
                <rect x="26" y="26" width="948" height="655" fill="none" stroke="#0072bc" stroke-width="2"/>
                <rect x="16" y="16" width="560" height="10" fill="#00843d"/><rect x="576" y="16" width="130" height="10" fill="#ffd100"/><rect x="706" y="16" width="130" height="10" fill="#ce1126"/><rect x="836" y="16" width="148" height="10" fill="#00a3dd"/>
                <rect x="16" y="681" width="560" height="10" fill="#00843d"/><rect x="576" y="681" width="130" height="10" fill="#ffd100"/><rect x="706" y="681" width="130" height="10" fill="#ce1126"/><rect x="836" y="681" width="148" height="10" fill="#00a3dd"/>
                <image href="../images/eac-crest.png" x="443" y="40" width="114" height="110" preserveAspectRatio="xMidYMid meet"/>
                <text x="500" y="178" text-anchor="middle" font-size="22" font-weight="bold" fill="#063f78">EAST AFRICAN COMMUNITY</text>
                <text x="500" y="226" text-anchor="middle" font-size="42" font-weight="bold">Certificate of Completion</text>
                <line x1="255" y1="246" x2="745" y2="246" stroke="#00843d" stroke-width="4"/>
                <text x="500" y="286" text-anchor="middle" font-size="19" font-style="italic" fill="#063f78">This is to certify that</text>
                <text id="cert-name" x="500" y="350" text-anchor="middle" font-size="48" font-weight="bold" fill="#063f78">PARTICIPANT</text>
                <text x="500" y="392" text-anchor="middle" font-size="18" font-style="italic" fill="#063f78">has successfully completed the online course on</text>
                <text id="cert-course" x="500" y="443" text-anchor="middle" font-size="29" font-weight="bold"><?= htmlspecialchars((string)($courseTitle ?? 'EAC Statistics E-Learning Course'), ENT_QUOTES, 'UTF-8') ?></text>
                <text x="500" y="478" text-anchor="middle" font-size="17" font-style="italic" fill="#063f78">offered under the EAC Statistics E-Learning Programme</text>
                <text id="cert-date" x="150" y="585" font-size="16" font-style="italic">Issued</text>
                <line x1="95" y1="600" x2="310" y2="600" stroke="#0072bc" stroke-width="2" stroke-dasharray="3 3"/>
                <text x="202" y="626" text-anchor="middle" font-size="16" fill="#063f78">Date</text>
                <text x="850" y="585" text-anchor="end" font-size="16" font-style="italic">East African Community</text>
                <line x1="690" y1="600" x2="905" y2="600" stroke="#0072bc" stroke-width="2" stroke-dasharray="3 3"/>
                <text x="798" y="626" text-anchor="middle" font-size="16" fill="#063f78">Secretary</text>
                <text id="cert-id" x="500" y="662" text-anchor="middle" font-size="15" font-style="italic" fill="#063f78">Certificate ID:</text>
            </svg>
        </div>
    </div>
</section>
<?php endif; ?>
