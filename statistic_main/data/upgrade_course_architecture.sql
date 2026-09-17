-- EAC Statistics e-Learning
-- Move built-in course launch paths to the shared course architecture.
UPDATE courses SET contentPath='courses/agriculture.php' WHERE id=1;
UPDATE courses SET contentPath='courses/fsi.php' WHERE id=2;
UPDATE courses SET contentPath='courses/gfs.php' WHERE id=3;
UPDATE courses SET contentPath='courses/psds.php' WHERE id=4;
UPDATE courses SET contentPath='courses/mfs.php' WHERE id=5;
UPDATE courses SET contentPath='courses/poverty.php' WHERE id=6;
UPDATE courses SET contentPath='courses/ess.php' WHERE id=7;
