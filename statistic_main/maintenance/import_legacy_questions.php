<?php
declare(strict_types=1);

if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
require_once __DIR__ . '/../api/config.php';
require_once __DIR__ . '/../api/Database.php';

$db = Database::connect();
$bank = require __DIR__ . '/../api/assessment_bank.php';
$courseData = [1=>'fns',2=>'fsi',3=>'gfs',4=>'psds',5=>'mfs',6=>'poverty',7=>'ess'];
$questionInsert = $db->prepare('INSERT INTO assessment_questions (courseId,questionType,moduleId,quizKey,title,questionText,explanation,sortOrder,isActive) VALUES (?,?,?,?,?,?,?,?,1)');
$optionInsert = $db->prepare('INSERT INTO assessment_options (questionId,optionText,isCorrect,sortOrder) VALUES (?,?,?,?)');
$count = $db->prepare('SELECT COUNT(*) FROM assessment_questions WHERE courseId=? AND questionType=?');

foreach ($courseData as $courseId => $key) {
    $db->beginTransaction();
    try {
        $count->execute([$courseId,'module_quiz']);
        if ((int)$count->fetchColumn() === 0) {
            $source = (string)file_get_contents(__DIR__ . '/../courses/data/' . $key . '.js');
            if (preg_match('/var\s+QUIZZES\s*=\s*(\[.*?\])\s*,\s*(?:DRAGDROPS|REVEALS|MODNAME)\s*=/s', $source, $match)) {
                $quizzes = json_decode($match[1], true, 512, JSON_THROW_ON_ERROR);
                foreach ($quizzes as $order => $q) {
                    $quizKey = trim((string)($q['id'] ?? ''));
                    preg_match('/^(m\d+)/i', $quizKey, $moduleMatch);
                    $questionInsert->execute([$courseId,'module_quiz',$moduleMatch[1]??null,$quizKey,$q['title']??'Knowledge Check',$q['question']??'',$q['feedbackCorrect']??'',(int)$order]);
                    $questionId=(int)$db->lastInsertId();
                    foreach (($q['options']??[]) as $optionOrder=>$option) $optionInsert->execute([$questionId,$option['text']??'',!empty($option['correct'])?1:0,(int)$optionOrder]);
                }
            }
        }

        $final = is_array($bank[$courseId] ?? null) ? $bank[$courseId] : [];
        $count->execute([$courseId,'final']);
        if ((int)$count->fetchColumn() === 0 && !empty($final['questions'])) {
            $db->prepare('INSERT INTO assessment_settings (courseId,questionsPerAttempt,passMark,minutes,intro) VALUES (?,?,?,?,?) ON DUPLICATE KEY UPDATE questionsPerAttempt=VALUES(questionsPerAttempt),passMark=VALUES(passMark),minutes=VALUES(minutes),intro=VALUES(intro)')->execute([$courseId,(int)($final['ask']??20),(float)($final['pass_mark']??80),(int)($final['minutes']??20),(string)($final['intro']??'')]);
            foreach ($final['questions'] as $order=>$q) {
                $questionInsert->execute([$courseId,'final',isset($q['module'])?'m'.(int)$q['module']:null,null,'Final Assessment',$q['q']??'',$q['explain']??'',(int)$order]);
                $questionId=(int)$db->lastInsertId();
                foreach (($q['options']??[]) as $optionOrder=>$option) $optionInsert->execute([$questionId,$option['text']??'',!empty($option['correct'])?1:0,(int)$optionOrder]);
            }
        }
        $db->commit();
        echo "Imported course {$courseId} ({$key})." . PHP_EOL;
    } catch (Throwable $error) {
        if ($db->inTransaction()) $db->rollBack();
        fwrite(STDERR, "Course {$courseId} failed: {$error->getMessage()}" . PHP_EOL);
        exit(1);
    }
}

echo "Legacy question import completed." . PHP_EOL;
