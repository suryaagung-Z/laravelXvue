<template>
    <div class="sub">
        <router-link :to="{ name: 'Products' }" exact-active-class="active"
            >All</router-link
        >
        <router-link
            :to="{ name: 'Products Trash' }"
            exact-active-class="active"
        >
            <font-awesome-icon icon="fa-solid fa-trash-can" />
            Trash
        </router-link>
    </div>
</template>

<style scoped>
.sub {
    display: flex;
    margin: 20px 0;
    gap: 10px;
}

.sub a {
    text-decoration: none;
    padding: 4px 10px;
    color: #000;
    background-color: transparent;
    border: 1px solid #000;
    border-radius: 5px;
}

.active {
    color: #fff !important;
    background-color: blue !important;
    border: 1px solid transparent !important;
}
</style>
