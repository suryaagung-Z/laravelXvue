<template>
    <main>
        <router-link :to="{ name: 'Products' }" class="back">
            <font-awesome-icon icon="fa-solid fa-arrow-left" /> Back
        </router-link>
        <h1>Update Product</h1>
        <form @submit.prevent="submitForm">
            <div class="each">
                <label for="product_name">Nama produk :</label>
                <input
                    type="text"
                    name="prodName"
                    id="product_name"
                    autocomplete="off"
                    v-model="inputs.prodName"
                />
                <p class="small" v-if="errors.product_name != null">
                    {{ errors.product_name }}
                </p>
            </div>

            <div class="each">
                <label for="harga">Harga :</label>
                <input
                    type="number"
                    name="price"
                    id="harga"
                    autocomplete="off"
                    v-model="inputs.price"
                />
                <p class="small" v-if="errors.price != null">
                    {{ errors.price }}
                </p>
            </div>

            <div class="each">
                <label for="product_category">Kategori produk :</label>
                <select
                    name="catProd"
                    id="product_category"
                    v-model="inputs.catProd"
                >
                    <option disabled value="">Pilih</option>
                    <option
                        v-for="category in categories"
                        :key="category.id"
                        :value="category.id"
                    >
                        {{ category.category_name }}
                    </option>
                </select>
                <p class="small" v-if="errors.category_product != null">
                    {{ errors.category_product }}
                </p>
            </div>

            <div class="each">
                <label for="production_date">Tanggal produksi :</label>
                <input
                    type="date"
                    name="prodDate"
                    id="production_date"
                    autocomplete="off"
                    v-model="inputs.prodDate"
                />
                <p class="small" v-if="errors.production_date != null">
                    {{ errors.production_date }}
                </p>
            </div>

            <button type="submit">Simpan</button>
        </form>
    </main>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";

export default {
    data() {
        return {
            categories: [],
            inputs: {
                id: null,
                prodName: null,
                price: null,
                catProd: "",
                prodDate: null,
            },
            errors: [
                "product_name",
                "price",
                "category_product",
                "production_date",
            ],
        };
    },
    methods: {
        submitForm() {
            axios({
                method: "PUT",
                url: `/api/products/update`,
                data: {
                    id: this.inputs.id,
                    product_name: this.inputs.prodName,
                    price: this.inputs.price,
                    category_product: this.inputs.catProd,
                    production_date: this.inputs.prodDate,
                },
            })
                .then((res) => {
                    const result = res.data;
                    if (result.hasOwnProperty("message")) {
                        Swal.fire({
                            icon: "success",
                            text: result.message,
                        });
                        // Redirect to Products page
                        this.$router.push({ name: "Products" });
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
                    for (const key in this.errors) this.errors[key] = null;
                    for (const [key, value] of Object.entries(result)) {
                        this.errors[key] = value[0];
                    }
                });
        },
    },
    created() {
        axios({
            method: "GET",
            url: `/api/products/id/${this.$route.params.id}`,
        })
            .then((res) => {
                const D = res.data;
                this.inputs.id = D.id;
                this.inputs.prodName = D.product_name;
                this.inputs.price = D.price;
                this.inputs.catProd = D.category_id;
                this.inputs.prodDate = D.production_date;
            })
            .catch((error) => {
                if (error.response.data.notFound) {
                    const sweetAlert = {
                        message: "Data tidak ditemukan",
                        icon: "error",
                    };
                    sessionStorage.clear();
                    sessionStorage.setItem(
                        "sweetAlert",
                        JSON.stringify(sweetAlert)
                    );
                    // Redirect to Products page
                    this.$router.push({ name: "Products" });
                }
            });

        axios({
            method: "GET",
            url: "/api/categories",
        })
            .then((res) => {
                this.categories = res.data;
            })
            .catch((error) => {
                console.log(error.response);
            });
    },
};
</script>

<style scoped>
h1 {
    margin: 20px 0;
}

form {
    width: 50%;
    display: flex;
    flex-direction: column;
    gap: 20px;
    border: 1px solid gray;
    padding: 20px;
}
form .each {
    display: inherit;
    flex-direction: inherit;
}

p.small {
    font-size: 0.8rem;
    color: red;
}

a.back {
    width: max-content;
    color: #fff;
    padding: 5px 10px;
    display: block;
    border-radius: 5px;
    background-color: blue;
    text-decoration: none;
}
</style>
