<?php 
    function myFirstFunction($name, $age) {
        echo "
            <p>
                Hi $name, I know your age is $age
            </p>
        ";
    }

    myFirstFunction("Devang", 22);
    myFirstFunction("Akshat", 21);
?>

<h1><?php bloginfo('name') ?> </h1>
<h1><?php bloginfo('description') ?> </h1>
<h1><?php bloginfo('wpurl') ?> </h1>
<h1><?php bloginfo('url') ?> </h1>
<h1><?php bloginfo('admin_email') ?> </h1>