<!DOCTYPE html>
<html>
<head>
    <title>PHP test</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <div class="row">
            <div class="header">Department</div>
            <div class="header">Name</div>
            <div class="header">Salary</div>
            <div class="header">Served for</div>
        </div>
        <?php
        $dbconnection = mysqli_connect("localhost:13306", "root", "verysecurerootpasswordiclassTECHtessolution12345672019docker", "employees");
        $managerQ = mysqli_query($dbconnection, "SELECT * FROM `dept_manager` WHERE `to_date`> cast(now() as date) ORDER BY `from_date` ASC");
        while ($manager = mysqli_fetch_assoc($managerQ)){
            // Get manager name from employees
            $managerInfoQ = mysqli_query($dbconnection, "SELECT CONCAT(`first_name`,' ',`last_name`) as name FROM `employees` WHERE `emp_no`='".$manager['emp_no']."'");
            $managerInfo =  mysqli_fetch_assoc($managerInfoQ);
            // Get manager dept_name from departments
            $managerDeptQ = mysqli_query($dbconnection, "SELECT `dept_name` FROM `departments` WHERE `dept_no`='".$manager['dept_no']."'");
            $managerDept = mysqli_fetch_assoc($managerDeptQ);
            // Get manager gender from employees
            $managerGenQ = mysqli_query($dbconnection, "SELECT `gender` FROM `employees` WHERE `emp_no`='".$manager['emp_no']."'");
            $managerGen =  mysqli_fetch_assoc($managerGenQ);
            // Get manager current Salary from salaries
            $managerSalaryQ = mysqli_query($dbconnection, "SELECT `salary` FROM `salaries` WHERE `to_date`> cast(now() as date) && `emp_no`='".$manager['emp_no']."'");
            $managerSalary = mysqli_fetch_assoc($managerSalaryQ);
            // Get manager serving Year from employees
            $managerYQ = mysqli_query($dbconnection, "SELECT FLOOR(SUM((DATEDIFF(cast(now() as date), `hire_date`) / 365.25))) as 'serve_for' FROM `employees` WHERE `emp_no`='".$manager['emp_no']."'");
            $managerY = mysqli_fetch_assoc($managerYQ);
            // Get numbers of employees currently under manager from dept_emp
            $dept_empNumQ = mysqli_query($dbconnection, "SELECT COUNT(`dept_no`) as dept_empNum FROM `dept_emp` WHERE `to_date`> cast(now() as date) && `dept_no`='".$manager['dept_no']."'");
            $dept_empNum = mysqli_fetch_assoc($dept_empNumQ);
            // Get emp_no currently under manager from dept_emp
            //$dept_empQ = mysqli_query($dbconnection, "SELECT `emp_no` FROM `dept_emp` WHERE `to_date`> cast(now() as date) && `dept_no`='".$manager['dept_no']."'");
            // $dept_empSalaryQ = mysqli_query($dbconnection, "SELECT SUM(`salary`) as total_salary FROM `salaries` WHERE `to_date`> cast(now() as date) && `emp_no`=(SELECT `emp_no` FROM `dept_emp` WHERE `to_date`> cast(now() as date) && `dept_no`='".$manager['dept_no']."')");
            // $dept_empSalary = mysqli_fetch_assoc($dept_empSalaryQ);

            echo '<div class="row gen'.$managerGen['gender'].'">
            <div class="">'.$managerDept['dept_name'].'</div>
            <div class="">'.$managerInfo['name'].'</div>
            <div class="num">'.$managerSalary['salary'].'</div>
            <div class="num">'.$managerY['serve_for'].'Years</div>
            </div>';
        }
        ?>
    </div>
</body>

</html>