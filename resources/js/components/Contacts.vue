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
        <div class="container border-css mt-5" style="width: 1300px;">
            <div class="header">
            <h1 class="col">Contacts</h1>
            <button type="button" class=" col-2 btn btn-primary" @click="showCreateModal">Add
                new
            </button>
                <button type="button" class="col-2 btn btn-danger del"  @click="deleteMarked">
                    Delete marked
                </button>
            </div>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>
                        <input type="checkbox" class="checkall"
                           :checked="checkedAll"
                           @change="checkAll($event.target.checked)">
                    </th>
                    <th></th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Address</th>
                    <th scope="col">Created at</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="contact in contacts" :key="contact.id">
                    <td scope="col">
                        <input
                            type="checkbox"
                            class="thing"
                            v-on:click="contact.checked = !contact.checked" :checked="contact.checked"
                        >
                    </td>
                    <td><i class="far fa-window-close"></i></td>
                    <td>{{ contact.name }}</td>
                    <td>{{ contact.email }}</td>
                    <td>{{ contact.address }}</td>
                    <td>{{ contact.timeString }}</td>
                    <td>
                        <TheDropdown
                            :contact="contact"
                            @viewContact="editPost(contact)"
                            @deleteContact="DeletePost(contact.id)"
                        />
<!--                        <button type="button" class="btn btn-warning" :contact="contact" @click="showCreateModal">-->
<!--                            Edit-->
<!--                        </button>-->
<!--                        <button type="button" class="btn btn-danger" @click="DeletePost(contact.id)">-->
<!--                            Delete-->
<!--                        </button>-->
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
            :contacts="contacts"
            :contact="deskProp"
        />
<!--        <DeleteModal-->
<!--            v-show="isDeleteModalVisible"-->
<!--            @close="closeDeleteModal"-->
<!--        />-->

    </div>
</template>

<script>
import CreateModal from "./CreateModal";
import TheDropdown from "./TheDropdown";
import moment from "vue-moment";


export default {
    components: {
        TheDropdown,
        CreateModal,
    },
    data () {
        return {
            contacts: [],
            checkedAll: false,
            contact: {
                id: '',
                name: '',
                email: '',
                address: '',
                updated_at: '',
                timeString: ''
            },
            deskProp: {},
            errored: false,
            isCreateModalVisible: false,
            timestamp:new Date().getFullYear()
        };
    },
    created() {
        setInterval(this.nowDate, 1000);
    },
    computed: {
        isChecked() {
            let tmpBool = false;
            let k = 0;
            this.contacts.forEach(i => {
                if (i.checked) {
                    tmpBool = true;
                    k++;
                }
            });
            if (!tmpBool) this.checkedAll = false;
            this.checkedAll = (k === this.contacts.length);
            return !tmpBool;
        }
    },
    methods: {
        showCreateModal() {
            this.isCreateModalVisible = true;
        },
        closeCreateModal() {
            this.isCreateModalVisible = false;
            this.getPosts();
        },
         getPosts() {
            axios
            .get("api/contact")
            .then(response => {
                this.contacts = response.data
            })
            .catch(error => {
                console.error(error)
                this.errored = true;
            })
            .finally(() => this.loading = false)
            this.contacts.forEach(i => {
                i.checked = false;
                i.timeString = moment(i.updated_at).fromNow();
                console.log(i.timeString);
            });

        },
        nowDate: function () {
            let today = new Date();
            let date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
            let time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
            let dateTime = date + ' ' + time;
            this.timestamp = dateTime;
        },
        editPost(contact) {
            console.log(contact);

            this.deskProp = contact;
            this.isCreateModalVisible = true;
        },
        nowDateDesks() {
            this.contacts.forEach(i => {
                i.timeString = moment(i.updated_at).fromNow();
            })
        },
        checkAll(checked) {
            this.checkedAll = true;
            this.contacts.forEach(i => {
                i.checked = checked;
            })
        },
        deleteMarked() {
            this.contacts.forEach(i => {
                if (i.checked) {
                    axios.delete('api/contact/' + i.id)
                        .then(response => {
                            this.getPosts();
                        })
                }
            })
            this.contacts = this.contacts.filter(i => i.checked === false);
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
    mounted() {
        this.getPosts()
    },
};
</script>
<style scoped>
.border-css{
    border: 2px solid;
}
.header{
    display: flex;
}
i {
    padding-left: 10px;
}
.btn-primary.add {
    margin-left: 900px;
}
.far,
.fas {
    margin-right: 7px;
}
.fa-sort {
    padding-left: 50px;
}
.table-title {
    font-size: 30px;
}
</style>


