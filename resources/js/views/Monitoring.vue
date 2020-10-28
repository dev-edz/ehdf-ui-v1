<template>
    <div id="Monitoring">
        <v-container fluid>
            <v-row no-gutters class="mb-2">
                <v-col cols="12" sm="12" md="4" class="d-flex py-0">
                    <v-text-field
                        class="text-uppercase font-weight-bold"
                        v-model="search"
                        outlined
                        dense
                        clearable
                        label="Search...">
                    </v-text-field>
                </v-col>
                <v-col cols="12" sm="12" md="4" offset-md="4" class="d-flex justify-end py-0">
                    <v-btn depressed md12 color="warning">Download Data</v-btn>
                </v-col>
            </v-row>
            <v-card outlined>
                <v-data-table
                    class="table-striped text-uppercase grey lighten-4"
                    :headers="dataTable.headers"
                    :items="indexedItems"
                    :loading="loading"
                    :items-per-page="-1"
                    :search="search"
                    hide-default-footer
                    fixed-header
                    height="70vh"
                    @click:row="handleRowClick"
                >
                    
                </v-data-table>
            </v-card>
        </v-container>
    </div>
</template>
<script>
export default {
    data(){
        return {
            search: '',
            loading: false,
            realtimeClock: '',
            clockInterval: '',
            selectingLogs: false,
            selectedLogs: [],
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
                        sortable: false,
                        value: 'UserOffice',
                        divider: true
                    },
                    {
                        text: 'Date & Time',
                        align: 'center',
                        sortable: true,
                        value: 'DateCreated',
                        divider: false,
                        width: '20%',
                    },
                ],
                items: [],
                refreshInterval: '',
            }
        }
    },
    computed: {
        indexedItems () {
            return this.dataTable.items.map((item, index) => ({
                id: index + 1,
                fullname: item.USERFULLNAME || (item.FirstName + ' ' + item.MiddleName + ' ' + item.LastName + ' ' + item.SuffixName),
                UserOffice: item.UserInfoID ? 'Philippine Overseas Employment Administration (POEA)' : item.Office,
                ...item
            }))
        },
    },
    methods: {
        loadTransactions(){
            this.loading = true;
            window.vue.prototype.$http.get('/api/transactions')
            .then(response => {
                this.dataTable.items = response.data;
                // this.dataTable.items["DateCreated"] = response.data["DateCreated"]
                this.loading = false;
                // console.log(response.data);
            }).catch(error => {
                console.log(error);
            })
        },
        refreshTransactions(){
            window.vue.prototype.$http.get('/api/transactions')
            .then(response => {
                this.dataTable.items = response.data;
            }).catch(error => {
                console.log(error);
            })
        },
        handleRowClick(item, row){
            console.log(row);
            if (row.isSelected === false){
                row.select(true);
                if (!this.selectedLogs.includes(item)) this.selectedLogs.push(item);
            }
            else {
                const index = this.selectedLogs.indexOf(item);
                this.selectedLogs.splice(index, 1);
                row.select(false);
            }                
            
            if (this.selectedLogs.length) this.selectingLogs = true
            else this.selectingLogs = false
        },
        handleClick(item, row){
            console.log(item, row)
        }

    },
    mounted(){
        this.loadTransactions();

        this.refreshInterval = setInterval(function(){
            this.refreshTransactions();
            console.log('refreshed...')
        }.bind(this), 3000);
    },
    beforeDestroy(){
        clearInterval(this.refreshInterval);
    }
}
</script>
<style>
    .theme--light.v-data-table tbody tr.v-data-table__selected {
        background: skyblue!important;
    }
</style>