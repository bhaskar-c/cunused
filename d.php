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
      
       echo "url: {$values['url']}";
       $pagecontent = file_get_contents($values['url']);
      echo $pagecontent;
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
