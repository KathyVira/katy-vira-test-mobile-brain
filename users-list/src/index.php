<?php
require_once 'app/functions.php';
$link = db_connect();

mysqli_set_charset($link, 'utf8');
$sql = 'SELECT * FROM users';
$result = mysqli_query($link, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
// $url = 'http://appslabs.net/mobile-brain-test/cudade.php';

$url = 'http://ip-api.com/json/';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="styles/style.css">    
            <title><?= $title ?></title>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <h1>Users List</h1>
                <div class="content">
                    <table class="table content">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">User phone</th>
                            <th scope="col">User location flag</th>
                            <th scope="col">User email</th>
                            <th scope="col">Action</th>
                        </tr>    
                        <?php if ($data): ?>     
                            <?php foreach ($data as $row): ?>             
                                <tr>
                                    <td><?= htmlspecialchars($row['id']) ?></td>
                                    <td><?= htmlspecialchars(
                                        $row['phone']
                                    ) ?></td>
                                    <td><?php
                                    $result = do_post($url, [$row['ip']]);
                                    $obj = json_decode($result);
                                    // print $row['ip'];

                                    $county = $obj->{'countryCode'};
                                    ?>
                                <img src="http://appslabs.net/mobile-brain-test/images/flags/<?= $county ?>.gif " ></img>    
                                </td>
                                    <td><?= htmlspecialchars(
                                        $row['email']
                                    ) ?></td>
                                    <td>
                                    <button type="button" class="btn btn-info">Edit</button>                                
                                        <button type="button" class="btn btn-success">Save</button> 
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                              <tr>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td><button type="button" class="btn btn-info">+</button></td>
                              </tr>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>