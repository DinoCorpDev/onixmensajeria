<template>
  <!--============================
         MENU HORIZONTAL
    ==============================-->
  <nav class="navbar navbar-expand-lg navbar-dark header">
    <div class="container">
      <a class="navbar-brand me-5" href="/">
        <img src="/img/logo_onix500x500.png" alt="logo" class="logo" />
      </a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#mainMenu"
        aria-controls="mainMenu"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse text-center" id="mainMenu">
        <!-- <ul class="navbar-nav me-auto mb-2 mb-lg-1">
          <li class="nav-item">
            <a class="nav-link" href="/">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">¿Quiénes somos?</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">La App</a>
          </li>
        </ul> -->
        <div class="ms-auto mb-2">
          <slot name="buttons"></slot>
        </div>
      </div>
    </div>
  </nav>
</template>

<style scoped>
.nav-link {
  font-size: 1rem;
  font-weight: 500;
}
</style>
