<!DOCTYPE html>
<html>
<head>
    <title>PHP test</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
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
        define('DB_HOST', 'mysql:3306');
        define('DB_NAME', 'employees');
        define('DB_USER', 'root');
        define('DB_PASSWORD', 'verysecurerootpasswordiclassTECHtessolution12345672019docker');
        
        $dbconnection = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
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
            // Get total salary of employees under manager from salaries and dept_emp
            $dept_empSalaryQ = mysqli_query($dbconnection, "SELECT SUM(`salary`) as total_salary FROM `salaries` WHERE `to_date`> cast(now() as date) && `emp_no`= any(SELECT `emp_no` FROM `dept_emp` WHERE `to_date`> cast(now() as date) && `dept_no`='".$manager['dept_no']."')");
            $dept_empSalary = mysqli_fetch_assoc($dept_empSalaryQ);
            //display table of the department, name, salary and serving Year for these managers
            echo '<div class="row gen'.$managerGen['gender'].'" onmousemove="tooltip(event)">
            <span class="tooltip">'
            .$dept_empNum['dept_empNum'].' employees under this manager</br>$'
            .$dept_empSalary['total_salary'].' spend on them totally
            </span>
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