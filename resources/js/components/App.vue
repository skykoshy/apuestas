<template>
    <main>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="/images/php.png" alt="" width="30" height="24">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <router-link exact-active-class="active" to="/" class="nav-link" aria-current="page">Inicio</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link exact-active-class="active" to="/players" class="nav-link">Jugadores</router-link>
                    </li>   
                     <li class="nav-item">
                        <router-link exact-active-class="active" to="/login" class="nav-link">Login</router-link>
                    </li>            
                     <li class="nav-item">
                        <router-link exact-active-class="active" to="/registro" class="nav-link">Registro</router-link>
                    </li>            
                </ul>
                </div>
            </div>
        </nav>
        <div class="container mt-5">
            <router-view></router-view>
        </div>
    </main>
</template>
 
<script>
    export default {}
</script>
