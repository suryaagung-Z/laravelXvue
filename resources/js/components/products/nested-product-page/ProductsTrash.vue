<template>
    <main>
        <table>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Tanggal Produksi</th>
                <th>Aksi</th>
            </tr>
            <tr v-for="(product, index) in products" :key="product.id">
                <td>{{ index + 1 }}</td>
                <td>{{ product.product_name }}</td>
                <td>{{ product.category.category_name }}</td>
                <td>{{ product.price }}</td>
                <td>{{ product.production_date }}</td>
                <td>
                    <a @click.stop="(event) => undo(product.id)">
                        <font-awesome-icon
                            icon="fa-solid fa-trash-can-arrow-up"
                        />
                    </a>
                    <a @click.stop="(event) => deletePermanent(product.id)">
                        <font-awesome-icon icon="fa-solid fa-trash-can" />
                    </a>
                </td>
            </tr>
        </table>
    </main>
</template>

<script>
import NavProducts from "../NavProductc.vue";
import axios from "axios";
import Swal from "sweetalert2";

export default {
    components: {
        NavProducts,
    },
    data() {
        return {
            products: [],
            att: 0,
        };
    },
    created() {
        this.fetchData();
    },
    mounted() {
        this.flashMessages;
    },
    computed: {
        flashMessages() {
            let get = sessionStorage.getItem("sweetAlert");
            if (get) {
                get = JSON.parse(get);
                Swal.fire({
                    icon: get.icon,
                    text: get.message,
                });
            }

            sessionStorage.clear();
        },
    },
    methods: {
        fetchData() {
            axios({
                method: "GET",
                url: "/api/products/trash",
            })
                .then((res) => {
                    this.products = res.data;
                })
                .catch((error) => {
                    console.log(error.response);
                });
        },
        deletePermanent(id) {
            Swal.fire({
                title: "Apa anda yakin?",
                text: "Hapus Permanen!",
                icon: "warning",
                showCancelButton: true,
                showCloseButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Hapus",
                cancelButtonText: "Batal",
            }).then((result) => {
                if (result.isConfirmed) {
                    axios({
                        method: "DELETE",
                        url: `/api/products/del/${id}/0`,
                    })
                        .then((res) => {
                            const result = res.data;
                            if (result.hasOwnProperty("message")) {
                                Swal.fire({
                                    icon: "success",
                                    text: result.message,
                                });

                                this.fetchData();
                            }
                        })
                        .catch((error) => {
                            const result = error.response.data;
                            if (result.hasOwnProperty("message")) {
                                Swal.fire({
                                    icon: "error",
                                    text: result.message,
                                });
                            }
                        });
                }
            });
        },
        undo(id) {
            Swal.fire({
                title: "Apa anda yakin?",
                text: "Kembalikan data seperti semula",
                icon: "warning",
                showCancelButton: true,
                showCloseButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Kembalikan",
                cancelButtonText: "Batal",
            }).then((result) => {
                if (result.isConfirmed) {
                    axios({
                        method: "PUT",
                        url: `/api/products/undo`,
                        data: { id },
                    })
                        .then((res) => {
                            const result = res.data;
                            if (result.hasOwnProperty("message")) {
                                Swal.fire({
                                    icon: "success",
                                    text: result.message,
                                });

                                this.fetchData();
                            }
                        })
                        .catch((error) => {
                            const result = error.response.data;
                            if (result.hasOwnProperty("message")) {
                                Swal.fire({
                                    icon: "error",
                                    text: result.message,
                                });
                            }
                        });
                }
            });
        },
    },
};
</script>

<style scoped>
table,
tr,
th,
td {
    padding: 5px;
    border: 1px solid lightgray;
    border-collapse: collapse;
}

table tr td a {
    font-size: 0.8rem;
    color: #fff;
    border: none;
    outline: none;
    cursor: pointer;
    margin: 0 5px;
    padding: 5px 10px;
    text-decoration: none;
    border-radius: 5px;
}

table tr td a:nth-child(1) {
    background-color: green;
}

table tr td a:nth-child(2) {
    background-color: red;
}
</style>
