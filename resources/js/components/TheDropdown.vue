<template>
    <div class="btn-group dropend">
        <button type="button" class="btn" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-ellipsis-v"></i>
        </button>
        <ul class="dropdown-menu" style="">
            <li><a class="dropdown-item" @click="$emit('viewContact')">
                <i class="fas fa-align-justify"></i>Edit</a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" @click="$emit('deleteContact')">
                <i class="fas fa-times "></i>Delete</a></li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "TheDropdown",
}
</script>

<style scoped>
.fa-times {
    color: red;
}
</style>
