<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Program Unit</div>

                    <div class="card-body">
                        <router-link to="/add-new-program-unit" class="btn btn-primary">
                            <i class="icon-plus"></i> Add New Program Unit
                        </router-link>

                        <hr>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">No.</th>
                                    <th>Unit</th>
                                    <th>Program Name</th>
                                    <th width="17%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(result,index) in results.data">
                                    <td>{{ results.from + index }}</td> 
                                    <td>{{ result.businessunit.unit_name }}</td>
                                    <td>{{ result.program_name }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <router-link :to="{ name:'programEdit', params: {id: result.id}}" class="btn btn-warning">
                                                <i class="fa fa-edit"></i>
                                            </router-link>
                                            <a class="btn btn-danger" v-on:click="deleteProgram(result.id, index)">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
                results: []
            }
        },
        mounted() {
            this.showData();
        },
        methods: {
            showData() {
                axios.get('/sosmed/program-unit')
                    .then(response => {
                        this.results = response.data;
                    });
            },

            deleteProgram(id,index) {
                if( confirm("Do you really want to delete it?")){
                    axios.delete('/sosmed/program-unit/'+id)
                        .then(response => {
                            this.showData();
                        }).catch(response => {
                            alert('could not delete it');
                        })
                }
            },

            paginate(url) {
                axios.get(url)
                    .then(response => {
                        this.results = response.data;
                    })
            }
        }
    }
</script>
