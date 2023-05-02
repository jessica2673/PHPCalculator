<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <title>Calculator</title>
    </head>

    <?php
        $num1 = $num2 = "";
        $num1_err = $num2_err = $op_err = "";
        $result = "";
        $background_color = "#f0d8db";
        $err_color = "red";

        function is_num(&$input, &$err) : bool {
            $input = trim($input);
            $input = stripslashes($input);
            $input = htmlspecialchars($input);
            if (is_numeric($input) !== true) {
                $err = "input must be a number";
                return false;
            } 
            $input = (float)$input;
            return true;
        }

        function calculate($num1, $num2, $op, &$background_color) : float {
            if ($op == "+") {
                $temp = $num1 + $num2;
                $background_color = "#d5f4f8";
            } else if ($op == "-") {
                $temp = $num1 - $num2;
                $background_color = "#d5f8d6";
            } else if ($op == "*") {
                $temp = $num1 * $num2;
                $background_color = "#e9d5f8";
            } else {
                $temp = $num1 / $num2;
                $background_color = "#f8f5d5";
            }
            return $temp;
        }

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $n1 = $n2 = $o = true;
            if (!is_numeric($_POST["num1"]) and $_POST["num1"] !== "0") {
                $num1_err = "*this field is required and must be a number";
                $n1 = false;
            }
            if (!is_numeric($_POST["num2"]) and $_POST["num2"] !== "0") {
                $num2_err = "*this field is required and must be a number";
                $n2 = false;
            }
            if (!isset($_POST["op"])) {
                $op_err = "*this field is required";
                $o = false;
            } 
            if ($n1 and $n2 and $o) {
                $num1 = $_POST["num1"];
                $num2 = $_POST["num2"];
                $op = $_POST["op"];

                if ($op == "/" and $num2 == "0") {
                    $op_err = "*cannot divide by 0";
                } else {
                    $result = calculate($num1, $num2, $op, $background_color);
                }
            }
        }
    ?>

    <body style=<?php echo "background-color:{$background_color};"?>>
        <h1>Calculator</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <span class="question">
                <label for="num1">First Number: </label>
                <input type="text" id="num1" name="num1" value="<?php echo $num1 ?>" autocomplete="off"> 
                <span style=<?php echo "color:{$err_color}"?>><?php echo $num1_err;?></span>
            </span><br>
            <span class="question">
                <label for="num2">Second Number: </label>
                <input type="text" id="num2" name="num2" value="<?php echo $num2 ?>" autocomplete="off">
                <span style=<?php echo "color:{$err_color}"?>><?php echo $num2_err;?></span>
            </span><br>
            
            <p>Operation: </p>
            <input type="radio" id="add" name="op" value="+" <?php if (isset($op) && $op == '+') {echo "checked";} ?>>
            <label class="select" for="add">+</label><br>
            <input type="radio" id="sub" name="op" value="-" <?php if (isset($op) && $op == '-') {echo "checked";}?>>
            <label class="select" for="sub">-</label><br>
            <input type="radio" id="mult" name="op" value="*" <?php if (isset($op) && $op == '*') {echo "checked";}?>>
            <label class="select" for="mult">*</label><br>
            <input type="radio" id="div" name="op" value="/" <?php if (isset($op) && $op == '/') {echo "checked";}?>>
            <label class="select" for="div">/</label><br>
            <input type="submit" value="submit" id="submit">
            <span style=<?php echo "color:{$err_color}"?>><?php echo $op_err;?></span><br>
        </form>

        <p>Result: <?php echo $result;?></p>
    </body>
</html>