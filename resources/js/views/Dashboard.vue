<template>
    <div id="Dashboard">
        <v-container>
            <v-row dense>
                <v-col cols="12" sm="12" md="6">
                    <!-- <v-card class="pa-1" height="30vh">
                        <v-card-title class="green pa-2 ma-2 white--text justify-center">UPDATES </v-card-title>
                        <v-card-text>
                            Updates goes here...
                        </v-card-text>
                    </v-card> -->
                    <v-card class="mb-4"
                        v-for="(menu, index) in dashboard.menus" :key="index"
                        :color="menu.color" 
                        dark 
                        outlined 
                        hover
                        :to="menu.link"

                    >
                        <v-card-title>
                            <v-icon
                                class="ml-4 mr-12"
                                size="64"
                            >
                                {{ menu.icon }}
                            </v-icon>
                            <span class="text-uppercase">
                                {{ menu.title }}
                            </span>
                            
                            <v-spacer></v-spacer>
                            <div class="display-2">
                                <strong>{{ menu.counter }}</strong>
                            </div>
                            <!-- <v-row align="end">
                                <div>
                                    <span
                                        class="display-0 font-weight-black"
                                    >
                                    <strong>{{ menu.title }}</strong>
                                    <v-spacer></v-spacer>
                                    {{ menu.counter }}</span>
                                </div>
                            </v-row> -->
                        </v-card-title>
                        <v-sparkline
                            :value="menu.values"
                            :labels="menu.labels"
                            color="rgba(255, 255, 255, .7)"
                            height="75"
                            padding="18"
                            stroke-linecap="round"
                            auto-draw
                            type="trend"
                        >

                        </v-sparkline>
                    </v-card>
                </v-col>
                <v-col cols="12" sm="12" md="6">
                    <v-card class="pa-1" outlined>
                        <img :src="dashboard.infoGraphics"/>
                    </v-card>
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
                    { title: 'Registered Users', icon: 'mdi-account-group', link: '#', counter: 0, color: 'blue darken-4', values: [], labels: [] },
                    { title: 'New Users', icon: 'mdi-account-details', link: '#', counter: 0, color: 'green', values: [], labels: [] },
                    { title: 'All Transactions', icon: 'mdi-format-list-text', link: '/monitoring', counter: 0, color: 'orange', values: [], labels: [] },
                ],
                // infoGraphics: "www.github.com/dev-edz/ehdf-ui-v1/blob/master/resources/img/eHDF-Infographics.png"
                infoGraphics: "../../img/ehdf_info2.png"
            }
        }
    },
    methods: {
        loadPersons(){
            window.vue.prototype.$http.get('/api/persons')
            .then(response => {
                this.dashboard.menus[0].counter = response.data.length;
            }).catch(error => {
                console.log(error);
            })
        },
        loadTransactions(){
            window.vue.prototype.$http.get('/api/transactions')
            .then(response => {
                this.dashboard.menus[2].counter = response.data.length;
            }).catch(error => {
                console.log(error);
            })
        },
        loadPersonsSummary(){
            window.vue.prototype.$http.get('/api/persons')
            .then(response => {
                window.vue.prototype.$http.get('/api/summary/persons')
                .then(res => {
                    for (const item of Object.entries(res.data)) {
                        this.dashboard.menus[0].labels.push(item[0]);
                        this.dashboard.menus[0].values.push(item[1].length);
                    }

                    console.log('persons summary...success')
                }).catch(error => {
                    console.log('error here 2...', error)
                });

            }).catch(error => {
                console.log('error here 1...')
            });
        },
        loadTransactionsSummary(){
            window.vue.prototype.$http.get('/api/summary/transactions')
            .then(res => {
                var i = [];
                for (const item of Object.entries(res.data)) {
                    this.dashboard.menus[2].labels.push('..');
                    this.dashboard.menus[2].values.push(item[1].length);
                    i.push(item[0])
                }
                
                this.dashboard.menus[2].labels[0] = i[0];
                this.dashboard.menus[2].labels[i.length - 1] = i[i.length - 1];

            }).catch(error => {
                console.log('error @ transaction summary', error)
            });
        },
        loadNewPersons(){

            window.vue.prototype.$http.get('/api/newpersons')
            .then(response => {
                this.dashboard.menus[1].counter = response.data.length;
                window.vue.prototype.$http.get('/api/summary/newpersons')
                .then(res => {
                    let i = 1;
                    for (const item of Object.entries(res.data)) {
                        this.dashboard.menus[1].labels.push(item[0]);
                        this.dashboard.menus[1].values.push(i);
                        i += 1;
                    }
                    console.log('new persons...success')
                }).catch(error => {
                    console.log('error @ new persons', error)
                });
            }).catch(error => {
                console.log(error);
            });
            
        }
        
    },
    mounted(){
        this.loadPersons();
        this.loadNewPersons();
        this.loadTransactions();
        this.loadPersonsSummary();
        this.loadTransactionsSummary();
    }
}
</script>
<style>  
    img {
        max-width: 100%;
        max-height: 100%;
        /* display: block; remove extra space below image */
    }
</style>