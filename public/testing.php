
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testing Ground</title>
</head>
<body>
    <h3><a href="index.php">Back to Main</a></h3>
    <?php
        echo "Class";

        class basicClass {
            public $name;
            public $age;

            function __construct($name)
            {
                $this->name = $name;
            }

            function callOut() {
                echo $this->name;
            }

        }

    ?>
    <p>Init obj</p>
    <?php

        $class = new basicClass("Alice");
        $class->callOut();
    
    ?>
    
</body>
</html>