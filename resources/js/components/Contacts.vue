<template>
    <div>
        <div>
            <header class="p-3 mb-3 border-bottom">
                <div class="row">
                    <div class="col-11">
                        <h3>Contact-list - {{ timestamp }}</h3>
                    </div>
                    <div class="dropdown text-end col-1 row">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <a>
                                    <img src="1.jpg" alt="mdo" width="33" height="33" class="rounded-circle">
                                </a>
                                Profile
                            </button>
                        </div>
                    </div>
                </div>
                <hr>
            </header>
        </div>
        <div class="mx-auto mt-5 row" style="width: 1300px;">
            <h1 class="col">Contacts</h1>
            <button type="button" class=" col-2 btn btn-primary" @click="showCreateModal">Add
                new
            </button>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col"><input id="all" type="checkbox"/></th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Address</th>
                    <th scope="col">Created at</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="contact in contacts" :key="contact.id">
                    <th scope="row"><input type="checkbox"/></th>
                    <td>{{ contact.name }}</td>
                    <td>{{ contact.email }}</td>
                    <td>{{ contact.address }}</td>
                    <td>{{ contact.updated_at }}</td>
                    <td>
                        <button type="button" class="btn btn-warning" @click="">
                            Edit
                        </button>
                        <button type="button" class="btn btn-danger" @click="DeletePost(contact.id)">
                            Delete
                        </button>
                    </td>
                </tr>

                </tbody>
            </table>
        </div>
        <div>
        </div>
        <CreateModal
            v-show="isCreateModalVisible"
            @close="closeCreateModal"
        />
<!--        <DeleteModal-->
<!--            v-show="isDeleteModalVisible"-->
<!--            @close="closeDeleteModal"-->
<!--        />-->

    </div>
</template>

<script>
import CreateModal from "./CreateModal";


export default {
    components: {
        CreateModal,

    },
    data () {
        return {
            contacts: [],
            contact: {
                id: '',
                name: '',
                email: '',
                address: '',
                updated_at: ''
            },
            isCreateModalVisible: false,
            timestamp:new Date().getFullYear()
        };
    },
    created() {
        setInterval(this.nowDate, 1000);
    },
    mounted() {
        this.getPosts()
    },
    methods: {
        showCreateModal() {
            this.isCreateModalVisible = true;
        },
        closeCreateModal() {
            this.isCreateModalVisible = false;
        },
        async getPosts() {
            await axios
            .get("api/contact")
            .then(response => {
                this.contacts = response.data
                console.log(response)
            })
            .catch(error => {
                console.log(error)
                this.errored = true;
            })
            .finally(() => this.loading = false)
        },
        nowDate: function () {
            let today = new Date();
            let date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
            let time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
            let dateTime = date + ' ' + time;
            this.timestamp = dateTime;
        },
        DeletePost(id) {
            axios
                .post('api/contact/' + id, {
                    _method: 'DELETE'
                })
                .then(response => {
                    this.contacts = []
                    this.getPosts();
                })
                .catch(error => {
                    console.log(error)
                    this.errored = true
                })

        },
    },
};
</script>


