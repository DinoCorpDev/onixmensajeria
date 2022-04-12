<template>
    <div>
        <div :class="changeActive ? 'content navigation open col' : 'content navigation col'">        
            <div class="menuToggle" v-on:click="activateMenu"></div>
            <ul>
                <li class="list" style="--clr:#f44336">
                    <a href="#">
                        <span class="icon"><i class="bi bi-person-circle"></i></span>
                        <span class="text">{{user && user.name ? user.name+' '+user.lastname : 'User test'}}</span>
                    </a>
                </li>
                <li :class="usersActive ? 'list active' : 'list' " style="--clr:#f44336">
                    <a href="#" v-on:click="activeLink('users')">
                        <span class="icon"><i class="bi bi-app-indicator"></i></span>
                        <span class="text">Usuarios</span>
                    </a>
                </li>
                <li :class="rolesActive ? 'list active' : 'list' " style="--clr:#ffa117">
                    <a href="#" v-on:click="activeLink('roles')">
                        <span class="icon"><i class="bi-briefcase-fill"></i></span>
                        <span class="text">Roles</span>
                    </a>
                </li>
                <li :class="attitudesActive ? 'list active' : 'list' " style="--clr:#0fc70f">
                    <a href="#" v-on:click="activeLink('attitudes')">
                        <span class="icon"><i class="bi bi-bookmark-plus-fill"></i></span>
                        <span class="text">Aptitudes</span>
                    </a>
                </li>
                <li :class="sectorsActive ? 'list active' : 'list' " style="--clr:#2196f3">
                    <a href="#" v-on:click="activeLink('sectors')">
                        <span class="icon"><i class="bi bi-shield"></i></span>
                        <span class="text">Sectores</span>
                    </a>
                </li>
                <li :class="logoutActive ? 'list active' : 'list' " style="--clr:#d321f3">
                    <a href="#" v-on:click="activeLink('logout')">
                        <span class="icon"><i class="bi bi-x-octagon-fill"></i></span>
                        <span class="text">Cerrar Sesion</span>
                    </a>
                </li>
            </ul>
        </div>
        <div v-if="user">        
            <div v-if="shoAttitudes">
                <AptitudesComponent :changeActive="changeActive"/>
            </div>

            <div v-if="showRoles">
                <RolesComponent :changeActive="changeActive"/>
            </div>

            <div v-if="showSectores">
                <SectoresComponent :changeActive="changeActive"/>
            </div>
        </div>
    </div>
</template>
<script>
import AptitudesComponent from '../Aptitudes/index.vue';
import RolesComponent from '../Roles/index.vue';
import SectoresComponent from '../Sectores/index.vue';

export default {
    props:['user','logout'],
    components:{
        AptitudesComponent,
        RolesComponent,
        SectoresComponent,
    },
    data(){
        return{
            changeActive: false,
            usersActive: true,
            rolesActive: false,
            attitudesActive: false,
            sectorsActive: false,
            logoutActive: false,

            showUsers:false,
            shoAttitudes:false,   
            showRoles:false,
            showSectores: false,
        }
    },
    mounted(){
        this.getUsers();
        console.log(this.user)
    },
    methods:{
        getUsers(){
            axios.get('getAllUsers').then((response)=>{
                console.log(response.data);
            })
        },

        activateMenu(){  
            if(this.changeActive === false){
                this.changeActive = true
            }else{
                this.changeActive = false
            }
        },
        activeLink(section){
            switch (section) {
                case 'users':
                    this.usersActive = true;
                    this.rolesActive = false;
                    this.attitudesActive = false;
                    this.sectorsActive = false;
                    this.logoutActive = false;

                    this.showUsers = true;
                    this.shoAttitudes = false;
                    this.showRoles= false;
                    this.showSectores= false;
                    break;
                case 'roles':
                    this.usersActive = false;
                    this.rolesActive = true;
                    this.attitudesActive = false;
                    this.sectorsActive = false;
                    this.logoutActive = false;

                    this.showUsers = false;
                    this.shoAttitudes = false;
                    this.showRoles= true;
                    this.showSectores= false;
                    break;

                case 'attitudes':
                    this.usersActive = false;
                    this.rolesActive = false;
                    this.attitudesActive = true;
                    this.sectorsActive = false;
                    this.logoutActive = false;

                    this.showUsers = false;
                    this.shoAttitudes = true;
                    this.showRoles= false;
                    this.showSectores= false;
                    break;

                case 'sectors':
                    this.usersActive = false;
                    this.rolesActive = false;
                    this.attitudesActive = false;
                    this.sectorsActive = true;  
                    this.logoutActive = false;   
                    
                    this.showUsers = false;
                    this.shoAttitudes = false;
                    this.showRoles= false;
                    this.showSectores= true;
                    break;                    
                case 'logout':
                    this.usersActive = false;
                    this.rolesActive = false;
                    this.attitudesActive = false;
                    this.sectorsActive = false;
                    this.logoutActive = true;

                    this.showUsers = false;
                    this.shoAttitudes = false;
                    this.showRoles= false;
                    this.showSectores= false;
                    this.logout();
                    break;
            }
        },
    }
}
</script>
<style>
@import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css");
@import url('https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800,900&display=swap');
*{
    margin:0;
    padding:0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;    
}
.content{
    width: 250px;
}
.navigation{
    position: fixed;
    inset: 55px 0 20px 0;
    width: 75px;
    background: #3d4152;
    transition: 0.5s;
    display:flex;
    grid-template-columns: 110px 110px 110px 110px;
    justify-content: center;
    align-items: center;
}
.navigation.open{
    width: 250px;
}
.navigation .menuToggle{
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 60px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.25);
    cursor:pointer;
    display:flex;
    align-items: center;
    justify-content: flex-start;
    padding: 0 23px;
}

.navigation .menuToggle::before{
    content: '';
    position: absolute;
    width: 30px;
    height: 2px;
    background: #fff;
    transform: translateY(-8px);
    transition: 0.5s;
}

.navigation .menuToggle::after{
    content: '';
    position: absolute;
    width: 30px;
    height: 2px;
    background: #fff;
    transform: translateY(8px);
    transition: 0.5s;
    box-shadow: 0 -8px 0 #fff;
}

.navigation.open .menuToggle::before{
    transform: translateY(0px) rotate(45deg);
}

.navigation.open .menuToggle::after{
    transform: translateY(0px) rotate(-45deg);
    box-shadow: 0 0 0 #fff;
}

.navigation ul{
    display:flex;
    flex-direction: column;
    gap: 10px;
    width: 100%;
}

ul{
    padding-left: 0.6rem;
}

.navigation ul li{
    list-style: none;
    position: relative;
    width: 100%;
    height: 60px;
    padding: 0 2px;
    transition: 0.5s;
}

.navigation ul li.active{
    transform: translateX(30px);
}

.navigation.open ul li.active{
    transform: translateX(10px);
}

.navigation ul li a{
    position: relative;
    display:flex;
    align-items: center;
    justify-content: flex-start;
    text-align: center;
    text-decoration: none;
}

.navigation ul li a .icon{
    position: relative;
    display:block;
    min-width: 55px;
    height: 55px;
    line-height: 60px;
    transition: 0.5s;
    border-radius: 10px;
    font-size: 1.75em;
    color: #fff;
}

.navigation ul li.active a .icon{
    color:#fff;
    background: var(--clr);
}

.navigation ul li a .icon::before{
    content: '';
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

.navigation ul li.active a .icon::before{
    opacity: 0.5;
}

.navigation ul li a .text{
    position: relative;
    padding: 0 15px;
    height: 60px;
    display:flex;
    align-items: center;
    color: #fff;
    opacity: 0;
    visibility: hidden;
    transition: 0.5s;
}

.navigation.open ul li a .text{
    opacity: 1;
    visibility:visible;
}

.navigation ul li.active a .text{
    color: var(--clr);
}
</style>