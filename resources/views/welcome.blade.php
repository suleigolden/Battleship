<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Battle Ship</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="css/style.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <?php use App\Http\Controllers\battleshipController;?>
 <div  id="container">
    <h1 class="title_text">Battle Ship</h1>
        <table cellpadding="5" cellspacing="5" border="0" id="gameTable">
            <thead>
                <tr><td>&nbsp;</td>
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
                <td>5</td>
                <td>6</td>
                <td>7</td>
                <td>8</td>
                <td>9</td>
                <td>10</td>
            </tr>
        </thead>
        <tbody>
 <?php echo battleshipController::createOnScreenGrid(); ?>

    </tbody>
</table>
</div>
    </body>
</html>
