<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Bussiness Unit</div>

                    <div class="panel-body">
                        <router-link to="/add-new-business-unit" class="btn btn-primary">
                            <i class="icon-plus"></i> Add New Business Unit 
                        </router-link>

                        <hr>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">No.</th>
                                    <th>Group</th>
                                    <th>Unit Name</th>
                                    <th width="17%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(unit, index) in units.data">
                                    <td>{{ units.from + index }}</td>
                                    <td>{{ unit.groupunit.group_name }}</td>
                                    <td>{{ unit.unit_name }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <router-link :to="{ name:'unitEdit', params: {id: unit.id}}" class="btn btn-sm btn-warning">
                                                <i class="fa fa-edit"></i>
                                            </router-link>
                                            <a class="btn btn-sm btn-danger" v-on:click="deleteUnit(unit.id, index)">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <ul class="pagination">
                            <li v-if="units.prev_page_url">
                                <a @click.prevent="paginate(units.prev_page_url)" :href="units.prev_page_url">&laquo; Previous</a>
                            </li>
                            <li v-if="units.next_page_url">
                                <a @click.prevent="paginate(units.next_page_url)" :href="units.next_page_url">Next &raquo;</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                units: []
            }
        },

        mounted() {
            this.showData();
        },

        methods: {
            showData() {
                axios.get('/sosmed/business-unit')
                    .then(response => {
                        this.units = response.data;
                    })
            },

            deleteUnit(id,index){
                if (confirm("Do you really want to delete it?")){
                    axios.delete('/sosmed/business-unit/'+id)
                        .then(response => {
                            this.showData();
                        }).catch(response => {
                            alert('could not delete unit');
                        })
                }
            },

            paginate(url) {
                axios.get(url).then(response => {
                    this.units = response.data;
                })
            }
        }
    }
</script>
