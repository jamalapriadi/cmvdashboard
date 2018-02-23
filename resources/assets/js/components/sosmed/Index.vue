<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Sosial Media</div>

                    <div class="card-body">
                        <router-link to="/add-new-sosial-media" class="btn btn-primary">
                            <i class="icon-plus"></i> Add New Sosial Media
                        </router-link>

                        <hr>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">No.</th>
                                    <th>Sosial Media Name</th>
                                    <th width="17%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for = "(result, index) in results.data">
                                    <td>{{ results.from + index}}</td>
                                    <td>{{ result.sosmed_name }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <router-link :to="{ name:'sosmedEdit', params: {id: result.id}}" class="btn btn-sm btn-warning">
                                                <i class="fa fa-edit"></i>
                                            </router-link>
                                            <a class="btn btn-sm btn-danger" v-on:click="deleteSosmed(result.id, index)">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <ul class="pagination">
                            <li v-if="results.prev_page_url">
                                <a @click.prevent="paginate(results.prev_page_url)" :href="results.prev_page_url">&laquo; Previous</a>
                            </li>
                            <li v-if="results.next_page_url">
                                <a @click.prevent="paginate(results.next_page_url)" :href="results.next_page_url">Next &raquo;</a>
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
                results: []
            }
        },
        mounted() {
            this.showData();
        },
        methods: {
            showData() {
                axios.get('/sosmed/sosmed')
                    .then(response => {
                        this.results = response.data;
                    });
            },

            deleteSosmed(id,index) {
                if ( confirm("Do you really want to delete it?")){
                    axios.delete('/sosmed/sosmed/'+id)
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
