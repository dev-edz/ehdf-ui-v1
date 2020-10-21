<template>
    <div id="Logs">
        <v-container fluid>
            <v-card outlined class="mx-auto mb-4">
                <v-card-title>Latest Log</v-card-title>
                <v-card-text>
                    <v-row>
                        <v-col cols="6">
                            dwad
                        </v-col>
                        <v-col cols="6">
                            dwadaw
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>
            <v-card outlined class="mx-auto mb-0">
                <v-card-title>Data Logs</v-card-title>
                <v-card-text>
                    <v-data-table
                        class="table-striped text-uppercase"
                        :headers="dataTable.headers"
                        :items="indexedItems"
                        :loading="loading"
                        :items-per-page="-1"
                        fixed-header
                        hover
                        height="55vh"
                        outline
                    >
                    </v-data-table>
                </v-card-text>
            </v-card>
        </v-container>
    </div>
</template>
<script>
export default {
    data(){
        return {
            loading: false,
            dataTable: {
                headers: [
                    {
                        text: 'No',
                        align: 'center',
                        sortable: false,
                        value: 'id',
                        divider: true,
                        width: '10%',
                    },
                    {
                        text: 'Fullname',
                        align: 'start',
                        sortable: false,
                        value: 'fullname',
                        divider: true
                    },
                    {
                        text: 'Office',
                        align: 'center',
                        sortable: true,
                        value: 'Office',
                        divider: true
                    },
                    {
                        text: 'Date & Time',
                        align: 'center',
                        sortable: false,
                        value: 'DateCreated',
                        divider: false,
                        width: '20%',
                    },
                ],
                items: []
            }
        }
    },
    computed: {
        indexedItems () {
            return this.dataTable.items.map((item, index) => ({
                id: index + 1,
                fullname: item.USERFULLNAME || (item.FirstName + ' ' + item.MiddleName + ' ' + item.LastName + ' ' + item.SuffixName),
                ...item
            }))
        }
    },
    methods: {
        loadTransactions(){
            this.loading = true;
            window.vue.prototype.$http.get('/api/transactions')
            .then(response => {
                this.dataTable.items = response.data;
                // this.dataTable.items["DateCreated"] = response.data["DateCreated"]
                this.loading = false;
                console.log(response.data);
            }).catch(error => {
                console.log(error);
            })
        }
    },
    mounted(){
        this.loadTransactions();
    }
}
</script>