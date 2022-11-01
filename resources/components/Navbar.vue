<template>
      <!-- <img src="../assets/img/pokemon_logo.png" width="30" height="30" class="d-inline-block align-top" alt="pokemon"> -->
  <div>
    <nav class="navbar navbar-expand-lg bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">
          <img src="../assets/img/pokemon_logo.png" width="100" height="30" class="d-inline-block align-top" alt="pokemon">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="/favorite">Favorite</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="/hate">Hate</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/like">Like</a>
            </li>
          </ul>
          <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form>
        </div>
      </div>
    </nav>
  </div>
</template>


<script>

    export default {
        data() {
            return {
                auth: '',
                user: '',
            }
        },

        methods:{
              logout() {
                  localStorage.removeItem('usertoken')
              }
            }
        }

</script>