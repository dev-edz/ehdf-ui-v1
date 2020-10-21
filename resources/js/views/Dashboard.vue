<template>
    <div id="Dashboard">
        <v-container fluid>
            <v-row class="mx-auto">
                <v-col class="">
                    <v-row>
                        <v-col 
                            class="mr-auto" 
                            v-for="(menu, index) in dashboard.menus" :key="index"
                            cols="6" md="3" sm="12">
                            <v-card>
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-list-item-title class="headline mb-1">Users</v-list-item-title>
                                        <v-list-item-subtitle>{{ menu.title }}</v-list-item-subtitle>
                                    </v-list-item-content>

                                    <v-avatar
                                        tile
                                        color="">
                                        <v-icon size="50">{{ menu.icon }}</v-icon>
                                    </v-avatar>
                                </v-list-item>
                            </v-card>
                        </v-col>
                    </v-row>
                    <v-row no-gutters>
                        <v-col class="mt-6">
                            <v-card class="transparent elevation-2">
                                <v-card-title>
                                    News and Events
                                </v-card-title>
                                <v-card-subtitle>
                                    What's New?
                                </v-card-subtitle>
                                <v-card-text>
                                    <!-- <p>Welcome to CDPV Portal version 1.0</p>
                                    <span>News and updates should be posted here...</span> -->
                                </v-card-text>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>
<script>
export default {
    data(){
        return {
            dashboard: {
                menus: [
                    { title: 'Users', icon: 'mdi-account-tie', counter: 0 },
                    { title: 'Users', icon: 'mdi-account-tie', counter: 0 },
                    { title: 'Users', icon: 'mdi-account-tie', counter: 0 },
                    { title: 'Users', icon: 'mdi-account-tie', counter: 0 },
                ]
            }
        }
    }
}
</script>