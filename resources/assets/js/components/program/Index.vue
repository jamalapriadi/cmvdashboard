<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Program Unit</div>

                    <div class="panel-body">
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
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(result,index) in results">
                                    <td>{{ results.from + index }}</td> 
                                    <td></td>
                                    <td></td>
                                    <td></td>
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
            console.log('Component mounted.')
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
