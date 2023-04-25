<template>
  <div class="home d-flex flex-column vh-100">
    <HorizontalMenu>
      <template v-slot:buttons>
        <a href="/login" class="btn btn-login px-4">Acceder</a>
        <!-- <a
          href="/register"
          class="btn btn-link text-white text-decoration-none px-4"
        >
          Registrarse
        </a> -->
      </template>
    </HorizontalMenu>
    <div class="container flex-grow-1">
      <div class="row align-items-center justify-content-center h-100"></div>
    </div>
  </div>
</template>

<script>
import HorizontalMenu from '../HorizontalMenu.vue'
export default {
  components: {
    HorizontalMenu,
  },
}
</script>

<style scoped>
.home {
  background-image: url('/img/mensajeria1.png');
  background-position: center center;
  background-repeat: repeat;
  background-size: contain;
}
.btn-login {
  background: #fff;
  border-color: #101a24;
  border-radius: 20px;
  color: #101a24;
}
.btn-login:hover {
  background: #101a24;
  border-color: #fff;
  border-radius: 20px;
  color: #fff;
}

@media (min-width: 768px) {
  .home {
    background-position: right center;
  }
}

@media (min-width: 576px) {
  .store-badge {
    height: 60px;
  }
}

@media (max-width: 576px) {
  .store-badge {
    width: 180px;
  }
}
</style>
