<template>
    <v-app>
        <v-navigation-drawer
            v-model="drawer.isOpen"
            color="blue darken-4"
            dark
            width="200px"
            app
            clipped
            overflow
        >
            <v-list 
                nav>
                <v-list-item
                    v-for="([text, icon, route], i) in drawer.navItems"
                    :key="i"
                    :to="route"
                    link
                >
                    <v-list-item-icon>
                        <v-icon>{{ icon }}</v-icon>
                    </v-list-item-icon>

                    <v-list-item-content>
                        <v-list-item-title>{{ text }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>
        <v-app-bar 
            color="blue darken-1"
            app 
            clipped-left 
            dense
            dark
            src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/bb/POEA.svg/1200px-POEA.svg.png"
        >
            <v-app-bar-nav-icon
                @click.stop="drawer.isOpen = !drawer.isOpen"
            ></v-app-bar-nav-icon>
            <v-toolbar-title>POEA - electronic Health Declaration Form Portal</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn 
                icon
                @click.stop="toggleTheme"
                primary
            >
                <v-icon>mdi-brightness-6</v-icon>
            </v-btn>
        </v-app-bar>

        <v-main>
            <router-view class="px-2"></router-view>
        </v-main>
    </v-app>
</template>
<script>
export default {
    data(){
        return {
            drawer: {
                isOpen: true,
                navItems: [
                    ['Dashboard', 'mdi-view-dashboard-outline', '/'],
                    ['Logs', 'mdi-clipboard-list-outline', '/logs'],
                ]
            },
        }
    },
    methods: {
        toggleTheme(){
            this.$vuetify.theme.dark = !this.$vuetify.theme.dark;
        },
    }
}
</script>
<style>
    a {
        text-decoration: none!important;
    }

    /* width */
    ::-webkit-scrollbar {
      width: 10px;
    }
    #nd-container::-webkit-scrollbar {
      display: none;
    }
    
    /* Track */
    ::-webkit-scrollbar-track {
      background: transparent;
      border-radius: 8px;
    }
     
    /* Handle */
    ::-webkit-scrollbar-thumb {
      background: #f1f1f1;
      border-radius: 8px;
    }
    
    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
      background: #555; 
    }
    html {
      overflow-y: hidden;
    }
    body {
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -o-user-select: none;
        user-select: none;
    }

</style>