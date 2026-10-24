<?php
$siteTheme = "main.css";
$centerName = "Future Skills Training Center";
define("CENTER_PHONE", "01011223344");
function displayCenterName() {
    global $centerName;
    return $centerName;}
function callByValue($message) {
    $message .= " - changed by Call by Value";
    return $message;
}
function callByReference(&$message) {
    $message .= " - changed by Call by Reference";
}
$courses = ["Web Development", "Graphic Design", "Data Analysis"];
$courseDetails = [
    "Web Development" => ["instructor" => "Ahmed Omar", "fee" => 2500],
    "Graphic Design" => ["instructor" => "Mona Ali", "fee" => 2000],
    "Data Analysis" => ["instructor" => "Omar Ahmed", "fee" => 3000]
];
function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, "UTF-8");}
$studentName = "";
$email = "";
$selectedCourse = "";
$graduationYear = "";
$errors = [];
$submitted = ($_SERVER["REQUEST_METHOD"] === "POST");
if ($submitted) {
    $studentName = trim($_POST["student_name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $selectedCourse = $_POST["course"] ?? "";
    $graduationYear = $_POST["graduation_year"] ?? "";
    if ($studentName === "") {
        $errors[] = "Please enter the student's name.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }
    if (!in_array($selectedCourse, $courses, true)) {
        $errors[] = "Please select a valid course.";
    }
    if (!ctype_digit((string)$graduationYear) ||
        (int)$graduationYear < 2010 ||
        (int)$graduationYear > ((int)date("Y") + 5)) {
        $errors[] = "Please select a valid graduation year.";
    }}
$valueMessage = "Original message";
$referenceMessage = "Original message";
$valueResult = callByValue($valueMessage);
callByReference($referenceMessage);

$sampleMessage = "Welcome to our training center";
$replacedMessage = str_replace("training", "learning", $sampleMessage);
$shortMessage = substr($sampleMessage, 0, 11);
$numberExample = 12.7;
$roundedUp = ceil($numberExample);
$integerValue = (int)$numberExample;
$isInteger = is_int($integerValue);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Training Center Registration System</title>
    <link rel="stylesheet" href="<?php echo e($siteTheme); ?>">
</head>
<body>
    <div class="container">
        <header class="site-header">
            <h1>Training Center Registration System</h1>
            <p>Welcome to <?php echo e(displayCenterName()); ?></p>
            <p class="contact">Contact: <?php echo e(CENTER_PHONE); ?></p>
        </header>

        <section class="panel">
            <h2>Available Training Courses</h2>
            <p>Courses from the indexed array:</p>
            <ul>
                <?php foreach ($courses as $course): ?>
                    <li><?php echo e($course); ?></li>
                <?php endforeach; ?>
            </ul>

            <h3>Course details</h3>
            <div class="course-grid">
                <?php foreach ($courseDetails as $courseName => $details): ?>
                    <article class="course-card">
                        <h4><?php echo e($courseName); ?></h4>
                        <p><strong>Instructor:</strong> <?php echo e($details["instructor"]); ?></p>
                        <p><strong>Fee:</strong> <?php echo e(number_format($details["fee"], 2)); ?> EGP</p>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="panel">
            <h2>Student Registration Form</h2>

            <?php if ($submitted && !empty($errors)): ?>
                <div class="alert error">
                    <strong>Please correct the following:</strong>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="post" action="">
                <label for="student_name">Student name</label>
                <input type="text" id="student_name" name="student_name"
                value="<?php echo e($studentName); ?>" required>

                <label for="email">Email address</label>
                <input type="email" id="email" name="email"
                value="<?php echo e($email); ?>" required>

                <label for="course">Select course</label>
                <select id="course" name="course" required>
                    <option value="">-- Choose a course --</option>
                    <?php foreach ($courses as $course): ?>
                        <option value="<?php echo e($course); ?>"
                            <?php echo ($selectedCourse === $course) ? "selected" : ""; ?>>
                            <?php echo e($course); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="graduation_year">Graduation year</label>
                <select id="graduation_year" name="graduation_year" required>
                    <option value="">-- Choose a year --</option>
                    <?php for ($year = 2010; $year <= (int)date("Y") + 5; $year++): ?>
                        <option value="<?php echo $year; ?>"
                            <?php echo ((string)$graduationYear === (string)$year) ? "selected" : ""; ?>>
                            <?php echo $year; ?>
                        </option>
                    <?php endfor; ?>
                </select>

                <button type="submit">Submit Registration</button>
            </form>

            <?php if ($submitted && empty($errors)): ?>
                <div class="alert success">
                    <h3>Registration Successful!</h3>
                    <p><strong>Student name:</strong> <?php echo e($studentName); ?></p>
                    <p><strong>Email:</strong> <?php echo e($email); ?></p>
                    <p><strong>Selected course:</strong> <?php echo e($selectedCourse); ?></p>
                    <p><strong>Graduation year:</strong> <?php echo e($graduationYear); ?></p>
                    <p><strong>Instructor:</strong> <?php echo e($courseDetails[$selectedCourse]["instructor"]); ?></p>
                    <p><strong>Course fee:</strong> <?php echo e(number_format($courseDetails[$selectedCourse]["fee"], 2)); ?> EGP</p>
                </div>
            <?php endif; ?>
        </section>

        <section class="panel">
            <h2>PHP Concepts Demonstration</h2>
            <h3>Call by Value</h3>
            <p><strong>Original variable:</strong> <?php echo e($valueMessage); ?></p>
            <p><strong>Returned result:</strong> <?php echo e($valueResult); ?></p>

            <h3>Call by Reference</h3>
            <p><strong>Modified variable:</strong> <?php echo e($referenceMessage); ?></p>

            <h3>String functions</h3>
            <p><strong>strtoupper():</strong> <?php echo e(strtoupper($sampleMessage)); ?></p>
            <p><strong>strlen() (message length):</strong> <?php echo strlen($sampleMessage); ?> characters</p>
            <p><strong>str_replace():</strong> <?php echo e($replacedMessage); ?></p>
            <p><strong>substr() (first 11 characters):</strong> <?php echo e($shortMessage); ?></p>

            <h3>Number functions</h3>
            <p><strong>Original number:</strong> <?php echo e($numberExample); ?></p>
            <p><strong>ceil():</strong> <?php echo e($roundedUp); ?></p>
            <p><strong>(int) conversion:</strong> <?php echo e($integerValue); ?></p>
            <p><strong>is_int() after conversion:</strong> <?php echo $isInteger ? "true (it is an integer)" : "false"; ?></p>
        </section>

        <footer>
            <p>&copy; <?php echo date("Y"); ?> <?php echo e($centerName); ?></p>
        </footer>
    </div>
</body>
</html>