<template>
    <div class="container-fluid">
        <div
            class="navigation overflow-auto"
            :class="[
                changeActive ? 'open col' : 'col',
                token ? 'navigation-login' : '',
            ]"
        >
            <div class="menuToggle">
                <img
                    width="70px"
                    src="/img/logo_onix500x500.png"
                    alt="logo"
                    class="d-md-none h-100"
                />
                <img
                    src="/img/logo_onix500x500.png"
                    alt="logo"
                    class="d-none d-md-block logo"
                />
            </div>
            <!--      <img src="/img/Header/logo.png" alt="logo" class="logo">&ndash;&gt;-->
            <div class="w-100" v-if="user">
                <div class="avatar mb-5 mt-5">
                    <span class="icon mb-2">
                        <i class="bi bi-person-circle"></i>
                    </span>
                    <span class="text-white">{{ user.names }}</span>
                </div>
                <ul class="ps-2 mb-5 ul-responsive">
                    <!--              <li :class="servicesActive ? 'list active' : 'list' " style="&#45;&#45;clr:#000">-->
                    <!--                <img src="/img/Header/logo.png" alt="logo" class="logo">-->
                    <!--              </li>-->
                    <li
                        :class="servicesActive ? 'list active' : 'list'"
                        style="--clr: #000"
                    >
                        <a href="#" @click.prevent="activeLink('services')">
                            <span class="icon">
                                <i class="bi bi-app-indicator"></i>
                            </span>
                            <span class="text">
                                <template v-if="idRol === 1">
                                    Pedidos
                                </template>
                                <template v-if="idRol === 2 || idRol === 3">
                                    Mis pedidos
                                </template>
                            </span>
                        </a>
                    </li>
                    <li
                        v-if="idRol !== 3"
                        :class="shopsActive ? 'list active' : 'list'"
                        style="--clr: #000"
                    >
                        <a href="#" @click.prevent="activeLink('shops')">
                            <span class="icon"><i class="bi bi-shop"></i></span>
                            <span v-if="idRol === 1" class="text">
                                Tiendas
                            </span>
                            <span v-else-if="idRol === 2" class="text">
                                Mi tienda
                            </span>
                        </a>
                    </li>
                    <li
                        v-if="idRol === 1"
                        :class="categoriesActive ? 'list active' : 'list'"
                        style="--clr: #000"
                    >
                        <a href="#" @click.prevent="activeLink('categories')">
                            <span class="icon">
                                <i class="bi bi-bookmark-check"></i>
                            </span>
                            <span class="text">Categorias</span>
                        </a>
                    </li>
                    <li
                        v-if="idRol === 1"
                        :class="usersActive ? 'list active' : 'list'"
                        style="--clr: #000"
                    >
                        <a href="#" @click.prevent="activeLink('users')">
                            <span class="icon">
                                <i class="bi bi-people"></i>
                            </span>
                            <span class="text">Usuarios</span>
                        </a>
                    </li>
                    <li
                        v-if="idRol === 1"
                        :class="rolesActive ? 'list active' : 'list'"
                        style="--clr: #000"
                    >
                        <a href="#" @click.prevent="activeLink('roles')">
                            <span class="icon">
                                <i class="bi bi-people"></i>
                            </span>
                            <span class="text">Roles</span>
                        </a>
                    </li>
                </ul>
            </div>
            <button
                type="button"
                class="btn btn-closesesion"
                @click="activeLink('sesion')"
            >
                Cerrar Sesión
            </button>
        </div>
        <div class="row" v-if="token && user">
            <div v-if="showServices" class="col">
                <servicesComponent :changeActive="changeActive" />
            </div>
            <div v-if="showStores" class="col">
                <shopsComponent :changeActive="changeActive" />
            </div>
            <div v-if="showCategories" class="col">
                <categoriesComponent :changeActive="changeActive" />
            </div>

            <div v-if="showUsers" class="col">
                <usersComponent :changeActive="changeActive" />
            </div>

            <div v-if="showRoles" class="col">
                <rolesComponent :changeActive="changeActive" />
            </div>
        </div>
    </div>
</template>

<script>
import { mapState, mapGetters, mapActions } from "vuex";

import servicesComponent from "../Services/index.vue";
import categoriesComponent from "../Categories/index.vue";
import shopsComponent from "../Shops/index.vue";
import usersComponent from "../Users/index.vue";
import rolesComponent from "../Roles/index.vue";

export default {
    components: {
        servicesComponent,
        categoriesComponent,
        shopsComponent,
        usersComponent,
        rolesComponent,
    },
    props: ["logout"],
    data() {
        return {
            changeActive: true,
            servicesActive: true,
            shopsActive: false,
            categoriesActive: false,
            sesionActive: false,
            usersActive: false,
            rolesActive: false,

            showRoles: false,
            showServices: true,
            showStores: false,
            showCategories: false,
            showUsers: false,
        };
    },
    computed: {
        ...mapState(["token", "user"]),
        ...mapGetters(["headers", "idRol"]),
    },
    created() {
        this.getUser();
        this.currentLink();
    },
    methods: {
        ...mapActions(["getUser"]),
        currentLink() {
            const url = new URL(window.location.href);
            const section = url.searchParams.get("section");

            this.activeLink(section);
        },
        activateMenu() {
            if (this.changeActive === false) {
                this.changeActive = true;
            } else {
                this.changeActive = false;
            }
        },
        activeLink(section) {
            const url = new URL(window.location.href);

            if (section != null) {
                url.searchParams.set("section", section);
                window.history.pushState({}, "", url);
            }

            switch (section) {
                case "services":
                    this.servicesActive = true;
                    this.shopsActive = false;
                    this.categoriesActive = false;
                    this.sesionActive = false;
                    this.usersActive = false;
                    this.rolesActive = false;

                    this.showServices = true;
                    this.showStores = false;
                    this.showCategories = false;
                    this.showUsers = false;
                    this.showRoles = false;
                    break;
                case "shops":
                    this.servicesActive = false;
                    this.shopsActive = true;
                    this.categoriesActive = false;
                    this.sesionActive = false;
                    this.showUsers = false;
                    this.showRoles = false;

                    this.showServices = false;
                    this.showStores = true;
                    this.showCategories = false;
                    this.usersActive = false;
                    this.rolesActive = false;
                    break;

                case "categories":
                    this.servicesActive = false;
                    this.shopsActive = false;
                    this.categoriesActive = true;
                    this.sesionActive = false;
                    this.showUsers = false;
                    this.showRoles = false;

                    this.showServices = false;
                    this.showStores = false;
                    this.showCategories = true;
                    this.usersActive = false;
                    this.rolesActive = false;
                    break;

                case "sesion":
                    this.servicesActive = false;
                    this.shopsActive = false;
                    this.categoriesActive = false;
                    this.sesionActive = true;
                    this.usersActive = false;
                    this.rolesActive = false;
                    this.logout();

                case "users":
                    this.servicesActive = false;
                    this.shopsActive = false;
                    this.categoriesActive = false;
                    this.sesionActive = false;
                    this.showUsers = true;
                    this.showRoles = false;

                    this.showServices = false;
                    this.showStores = false;
                    this.showCategories = false;
                    this.usersActive = true;
                    this.rolesActive = false;
                    break;

                case "roles":
                    this.servicesActive = false;
                    this.shopsActive = false;
                    this.categoriesActive = false;
                    this.sesionActive = false;
                    this.showUsers = false;
                    this.showRoles = true;

                    this.showServices = false;
                    this.showStores = false;
                    this.showCategories = false;
                    this.usersActive = false;
                    this.rolesActive = true;
                    break;
            }
        },
    },
};
</script>

<style lang="scss">
.navigation {
    position: fixed;
    inset: 55px 0 20px 0;
    width: 75px;
    background: #101a24;
    transition: 0.5s;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    height: 100%;
    padding: 2rem 1rem;
    min-width: 100px;
}
.btn-closesesion {
    background: #fff;
    border-radius: 15px;
    color: #101a24;
}
.btn-closesesion:hover {
    background: #101a24 !important;
    border: 1px solid #fff !important;
    border-radius: 15px;
    color: #fff !important;
}
@media (max-width: 575px) {
    .navigation {
        margin-right: 250px;
    }
}

@media (min-width: 768px) {
    .navigation.open {
        width: 250px;
    }

    .navigation.open ul li a .text {
        opacity: 1;
        visibility: visible;
    }
}

@media (max-width: 767px) {
    .ul-responsive {
        margin-left: -15px;
    }
}

.navigation-login {
    inset: 0px 0 20px 0;
}

/*
.navigation.open {
  width: 250px;
} */

.navigation .menuToggle {
    cursor: pointer;
}

/* .navigation .menuToggle::before {
  content: "";
  position: absolute;
  width: 20px;
  height: 2px;
  background: #fff;
  transform: translateY(-8px);
  transition: 0.5s;
}

.navigation .menuToggle::after {
  content: "";
  position: absolute;
  width: 20px;
  height: 2px;
  background: #fff;
  transform: translateY(8px);
  transition: 0.5s;
  box-shadow: 0 -8px 0 #fff;
} */

/* .navigation.open .menuToggle::before {
  transform: translateY(0px) rotate(45deg);
}

.navigation.open .menuToggle::after {
  transform: translateY(0px) rotate(-45deg);
  box-shadow: 0 0 0 #fff;
} */

.navigation ul {
    display: flex;
    flex-direction: column;
    gap: 10px;
    width: 100%;
}

.navigation ul li {
    list-style: none;
    position: relative;
    width: 100%;
    height: 60px;
    padding: 0 2px;
    transition: 0.3s;
}

.navigation ul li.active {
    transform: translateX(30px);
}

.navigation.open ul li.active,
.navigation.open ul li:hover {
    transform: translateX(10px);
}

.navigation ul li a {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    text-align: center;
    text-decoration: none;
}

.navigation ul li a .icon {
    position: relative;
    display: block;
    min-width: 50px;
    height: 50px;
    line-height: 52px;
    transition: 0.5s;
    border-radius: 100%;
    border: 2px solid #ffffff;
    font-size: 1.75em;
    color: #ffffff;
}

.navigation ul li.active a .icon {
    color: #101a24;
    background: #ffffff;
    border-radius: 100%;
}

.avatar {
    display: flex;
    align-items: center;
    flex-direction: column;
    justify-content: center;

    .icon {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 50px;
        height: 50px;
        border-radius: 100%;
        border: 2px solid #ffffff;
        font-size: 1.75em;
        color: #ffffff;
    }
}

/* .navigation ul li a .icon::before {
  content: "";
  position: absolute;
  top: 10px;
  left: 0;
  width: 100%;
  height: 100%;
  background: var(--clr);
  filter: blur(8px);
  opacity: 0;
  transition: 0.5s;
}

.navigation ul li.active a .icon::before {
  opacity: 0.5;
} */

.navigation ul li a .text {
    position: relative;
    padding: 0 15px;
    height: 60px;
    display: flex;
    align-items: center;
    color: #fff;
    opacity: 0;
    visibility: hidden;
    transition: 0.5s;
}

/* .navigation.open ul li a .text {
  opacity: 1;
  visibility: visible;
} */
</style>
