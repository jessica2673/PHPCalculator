<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Calculator</title>
    </head>

    <?php
        $num1 = $num2 = "";
        $num1_err = $num2_err = $op_err = "";
        $result="";

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

        function calculate($num1, $num2, $op) : float {
            if ($op == "+") {
                $temp = $num1 + $num2;
            } else if ($op == "-") {
                $temp = $num1 - $num2;
            } else if ($op == "*") {
                $temp = $num1 * $num2;
            } else {
                $temp = $num1 / $num2;
            }
            return $temp;
        }

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $n1 = $n2 = $o = true;
            if (!preg_match_all("/^[0-9]+$/", $_POST["num1"])) {
                $num1_err = "*this field is required and must be a number";
                $n1 = false;
            }
            if (!preg_match_all("/^[0-9]+$/", $_POST["num2"])) {
                $num2_err = "*this field is required and must be a number";
                $n2 = false;
            }
            if ($n2 and !is_num($_POST["num2"], $num2_err)) {
                $num2_err = "*this field must be a number";
                $n2 = false;
            } 
            if ($n1 and $n2 and $o) {
                $num1 = $_POST["num1"];
                $num2 = $_POST["num2"];
                $op = $_POST["op"];

                if ($op == "/" and $num2 == "0") {
                    $op_err = "cannot divide by 0";
                } else {
                    var_dump($num2);
                    $result = calculate($num1, $num2, $op);
                }
            }
        }
    ?>

    <body>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <label for="num1">First Number: </label>
            <input type="text" id="num1" name="num1" value="<?php echo $num1 ?>">
            <?php echo $num1_err;?><br>
            <label for="num2">Second Number: </label>
            <input type="text" id="num2" name="num2" value="<?php echo $num2 ?>">
            <?php echo $num2_err;?>
            
            <p>Operation: </p>
            <input type="radio" id="add" name="op" value="+" <?php if (isset($op) && $op == '+') {echo "checked";} ?>>
            <label for="add">+</label><br>
            <input type="radio" id="sub" name="op" value="-" <?php if (isset($op) && $op == '-') {echo "checked";}?>>
            <label for="sub">-</label><br>
            <input type="radio" id="mult" name="op" value="*" <?php if (isset($op) && $op == '*') {echo "checked";}?>>
            <label for="mult">*</label><br>
            <input type="radio" id="div" name="op" value="/" <?php if (isset($op) && $op == '/') {echo "checked";}?>>
            <label for="div">/<label><br>
            <input type="submit" name="submit" value="submit" ><br>
            <?php echo $op_err?>
        </form>

        <p>Result: </p><?php echo $result;?>
    </body>
</html>