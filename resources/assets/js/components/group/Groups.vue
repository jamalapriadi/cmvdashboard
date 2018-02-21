<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Group</div>

                    <div class="panel-body">
                        <router-link to="/add-new-group" class="btn btn-primary">
			                Add New Group
		                </router-link>
                        <hr>

                        <div class="row">
                            <div class="col-lg-3">
                                <div class="input-group">
                                    
                                </div>
                            </div>
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">No.</th>
                                    <th></th>
                                    <th>Group Name</th>
                                    <th width="17%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(group, index) in groups.data">
                                    <td>{{ groups.from + index }}</td>
                                    <td></td>
                                    <td>{{ group.group_name }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <router-link :to="{ name:'groupEdit', params: {id: group.id}}" class="btn btn-warning">
                                                <i class="fa fa-edit"></i>
                                            </router-link>
                                            <a class="btn btn-danger" v-on:click="deleteGroup(group.id, index)">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <ul class="pagination">
                            <li v-if="groups.prev_page_url">
                                <a @click.prevent="paginate(groups.prev_page_url)" :href="groups.prev_page_url">&laquo; Previous</a>
                            </li>
                            <li v-if="groups.next_page_url">
                                <a @click.prevent="paginate(groups.next_page_url)" :href="groups.next_page_url">Next &raquo;</a>
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
                groups: []
            }
        },

        mounted() {
            this.showData();
            MessageBox("Good job!", "You clicked the button!", "success");
        },

        methods: {
            showData() {
                axios.get('/sosmed/group-unit')
                    .then(response => {
                        this.groups = response.data;
                    })
            },

            deleteGroup(id,index){
                if (confirm("Do you really want to delete it?")){
                    axios.delete('/sosmed/group-unit/'+id)
                        .then(response => {
                            this.showData();
                        }).catch(response => {
                            alert('could not delete group');
                        })
                }
            },

            paginate(url) {
                axios.get(url).then(response => {
                    this.groups = response.data;
                })
            }
        }
    }
</script>
