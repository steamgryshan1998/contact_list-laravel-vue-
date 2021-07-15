<template>
    <div>
        <div>
            <header class="mb-3 border-bottom">
                <div class="row">
                    <div class="col-11 title">
                        <h3 class="main_header">Contact-list - {{ timestamp }}</h3>
                    </div>
                    <div class="dropdown profile text-end col-1 row">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle profile_header" type="button"
                                    id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="far fa-user-circle"></i>
                                Profile
                            </button>
                        </div>
                    </div>
                </div>
                <hr>
            </header>
        </div>
        <div class="container border-css mt-5">
            <div class="header">
                <h1 class="col name">Contacts</h1>
                <div class="col-2">
                    <button type="button" class="btn contact_button btn-primary " @click="showCreateModal">
                        <!--                todo font awesome-->
                        <i class="fas fa-user-plus"></i>
                        Add new
                    </button>
                </div>
                <div class="col-2">
                    <button type="button" class="btn btn-danger del align-middle delete_marked_button" @click="deleteMarked">
                        <i class="fas fa-user-times"></i>
                        Delete marked
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-10">
                    <table class="table table-bordered">
                        <tr>
                            <td scope="col">
                                <input type="checkbox" class="checkall"
                                       :checked="checkedAll"
                                       @change="checkAll($event.target.checked)">
                            </td>
                            <td></td>
                            <td class="col-lg-3" scope="col">
                                <div
                                    @click="sortBy('name')"
                                    style="cursor: pointer">
                                    Name
                                    <i class="fas fa-sort"></i>
                                </div>

                            </td>
                            <td class="col-lg-3" scope="col">
                                <div
                                    @click="sortBy('email')"
                                    style="cursor: pointer">
                                    Email
                                    <i class="fas fa-sort"></i>
                                </div>

                            </td>
                            <td class="col-lg-3" scope="col">
                                <div
                                    @click="sortBy('address')"
                                    style="cursor: pointer">
                                    Address
                                    <i class="fas fa-sort"></i>
                                </div>
                            </td>
                            <td class="col-lg-3" scope="col">
                                <div
                                    @click="sortBy('updated_at')"
                                    style="cursor: pointer">
                                    Created at
                                    <i class="fas fa-sort"></i>
                                </div>
                            </td>
                            <td scope="col"></td>
                        </tr>
                        <tr v-for="contact in contacts" :key="contact.id">
                            <td scope="col">
                                <input
                                    type="checkbox"
                                    class="thing"
                                    v-on:click="contact.checked = !contact.checked" :checked="contact.checked"
                                >
                            </td>
                            <td><i class="far fa-window-close"></i></td>
                            <td><a href="#">{{ contact.name }}</a></td>
                            <td>{{ contact.email }}</td>
                            <td>{{ contact.address }}</td>
                            <td>{{ moment(contact.updated_at).fromNow() }}</td>
                            <td>
                                <TheDropdown
                                    :contact="contact"
                                    @viewContact="editPost(contact)"
                                    @deleteContact="DeletePost(contact.id)"
                                />
                            </td>
                        </tr>

                    </table>
                </div>
                <div class="col-sm-2">

                </div>
            </div>
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


export default {
    components: {
        TheDropdown,
        CreateModal,
    },
    data() {
        return {
            contacts: [],
            checkedAll: false,
            sort: {
                name: true,
                email: true,
                address: true,
                updated_at: true,
            },
            contact: {
                id: '',
                name: '',
                email: '',
                address: '',
                updated_at: ''
            },
            deskProp: {},
            errored: false,
            isCreateModalVisible: false,
            timestamp: new Date().getFullYear()
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

        checkAll(checked) {
            this.checkedAll = true;
            this.contacts.forEach(i => {
                i.checked = checked;
            })
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
        deleteMarked() {
            let n = 0;
            this.contacts.forEach(i => {
                if (i.checked) {
                    axios.delete('api/contact/' + i.id)
                        .then(response => {
                            this.getPosts();
                        })
                    n++;
                }
            })
            if (n === 0) {
                this.getPosts();
            }
            this.contacts = this.contacts.filter(i => i.checked === false);
        },
        sortBy(field) {
            this.contacts = this.contacts.sort(compare(field, this.sort[field]));
            this.sort[field] = !this.sort[field];
        },
    },
    mounted() {
        this.getPosts()
    },
};

function compare(field, isAscending = true) {
    return function (a, b) {
        let type = typeof (a[field]);
        if (type === 'number')
            if (isAscending)
                return a[field] - b[field];
            else
                return b[field] - a[field];
        else {
            if (isAscending) {
                if (a[field] < b[field]) return -1;
                if (a[field] > b[field]) return 1;
                return 0;
            } else {
                if (a[field] > b[field]) return -1;
                if (a[field] < b[field]) return 1;
                return 0;
            }
        }
    }
}
</script>
<style scoped>
header {
    margin: 0;
    padding-bottom: 0;
    padding-top: 1rem !important;
    padding-right: 1rem !important;
    padding-left: 1rem !important;
}

.main_header {
    font-family: var(--bs-font-sans-serif);
    /*font-family: 'Lato', sans-serif;*/
    color: white;
    font-size: 1rem;
}

.profile_header {
    background-color: #7F4C00;
}

hr {
    border: 1px solid white;
}

.title {
    padding-top: calc(var(--bs-gutter-x) * .5);
    margin-left: 12px;
}

.profile {
    padding-left: 0;
}

.container {
    min-width: 1600px;
}

.border-css {
    border: 2px solid;
    border-radius: 10px;
}

table {
    color: #a79294;
    border-color: #e6e1e5;
}


.contact_button {
    margin-top: 1rem;
    margin-left: 130px;
    margin-bottom: 0.5rem;

}

.delete_marked_button{
    margin-top: 1rem;
    margin-left: 5rem;
    margin-bottom: 0.5rem;

}

.header {
    display: flex;
    padding-bottom: 0;
}

.name {
    font-size: 1.5rem;
    margin-bottom: 0;
    padding-top: 1rem;
    padding-left: 1rem;
}

i {
    padding-left: 10px;
    margin-right: 10px;
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


