<style>td.error{ color: red;} </style>
<?php
     
function VerifyForm(&$values, &$errors)
    {
    if (strlen($values['url']) < 3)
    $errors['url'] = 'Name too short';
    elseif (strlen($values['url']) > 50)
    $errors['url'] = 'Name too long';
    return (count($errors) == 0);
    }
     
function DisplayForm($values, $errors)
    {
        if (count($errors) > 0)
                echo "<p>There were some errors in your submitted form, please correct them and try again.</p>";
        ?>
         
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
        URL to be Analyzed:</br>
        <input type="text" size="30" name="url" value="<?= htmlentities($values['url']) ?>"/>
        <div class="error"><?= $errors['url'] ?></div>
        <div><input type="submit" value="Submit"></div>
        </form>
         <?php
}
     
function ProcessForm($values)
    {
      
       echo "url: {$values['url']}<br>";
       //$pagecontent = htmlspecialchars(file_get_contents($values['url']));
       //echo  $pagecontent;
       require_once 'simple_html_dom.php';
       echo "<h3>Following CSS files analyzed:</h3>";
       $website = file_get_html($values['url']);
       foreach ($website->find('link[rel="stylesheet"]') as $stylesheet)
        {
            $stylesheet_url = $stylesheet->href;
        // Do something with the URL
        echo "{$stylesheet_url} <br>";
        echo "<br>***********************************************************<br>";
        echo file_get_contents($stylesheet_url);
        echo "<br>***********************************************************<br>";
        }
      
    }
     
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
    $formValues = $_POST;
    $formErrors = array();
     
    if (!VerifyForm($formValues, $formErrors))
    DisplayForm($formValues, $formErrors);
    else
    ProcessForm($formValues);
    }
    else
    DisplayForm(null, null);
    ?>
