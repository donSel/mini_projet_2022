<!DOCTYPE html>
<html lang=fr>
    <head>
        <meta charset=utf-8>
        <title>Se connecter</title>
         <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
          rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" 
          crossorigin="anonymous">
       <!-- Mon css -->
       <link href="style.css" rel="stylesheet">
    </head>
    
    <body>
    <div class="container-fluid bg-primary">
        <nav class="navbar navbar-dark">
            <div class="container-fluid">
            <a class="navbar-brand" href="accueil.php">
                <img src="images/caduceus-2029254_640.webp" width="50" height="60">
                здоровье
            </a>
            </div>
        </nav>
    </div>
    <br>
    <br>
    <div class="text-center">
    
    <main class="form-signin">
      <form class="">
        <img class="mb-4" src="images/caduceus-2029254_640.webp" width="70" height="84">
        <h1 class="h3 mb-3 fw-normal">Connection</h1>
    
        <div class="form-floating">
          <input type="email" class="form-control" placeholder="name@example.com">
          <label for="floatingInput">Adresse mail</label>
        </div>
        <div class="form-floating">
          <input type="password" class="form-control" placeholder="Password">
          <label for="floatingPassword">Mot de passe</label>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Se connecter</button>
      </form>
    </div>
    </body>
</html>