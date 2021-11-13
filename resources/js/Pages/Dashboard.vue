<template>
  <!---------------------Heder-------------------->
  <app-layout title="وسایل">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">وسایل</h2>
    </template>

    <!------------------------section---------------------->
    <div class="py-12 ml-0 row g-2">
      <!---------------------Locations------------------->
      <div class="py-4 mr-2 bg-white shadow-xl col-2 sm:rounded-lg">
        <div class="flex bg-gray-100 border-b-2 border-gray-200" id="parent0">
          <div @click="getOfThis(0)" class="me-auto Pointer">
            <p class="Pointer">کلیه ی مکان ها</p>
          </div>
          <div @click="oppenCreateLocation(null)">
            <i
              class="mx-2 text-gray-300 fas fa-map-marker-alt Pointer hover:text-green-400"
            ></i>
          </div>
        </div>
        <div
          v-for="(location, key) in locations"
          :key="key"
          class="border-b-2 border-gray-200"
          :id="`parent${location.id}`"
        >
          <div class="flex">
            <div @click="getOfThis(location.id)" class="me-auto Pointer">
              <p class="Pointer">{{ location.name }}</p>
            </div>
            <div
              v-if="location.user_id == userId"
              @click="hiddenLocation(location.id)"
            >
              <div v-if="location.hidden == 0">
                <i
                  class="text-gray-300 fas fa-eye Pointer hover:text-blue-500"
                  :id="`element${location.id}`"
                ></i>
              </div>
              <div v-if="location.hidden == 1">
                <i
                  :id="`element${location.id}`"
                  class="text-gray-300 fas fa-eye-slash Pointer hover:text-blue-500"
                ></i>
              </div>
            </div>
            <div class="mx-2" @click="oppenCreateDevice(location.id)">
              <i
                class="text-gray-300 fas fa-tshirt Pointer hover:text-yellow-500"
              ></i>
            </div>
            <div @click="oppenCreateLocation(location.id)">
              <i
                class="text-gray-300 fas fa-map-marker-alt Pointer hover:text-green-400"
              ></i>
            </div>
            <div
              class="mx-2"
              @click="alertDeleteLocation(location.id, location.name)"
            >
              <i
                class="text-gray-300 fas fa-trash-alt Pointer hover:text-red-600"
              ></i>
            </div>
          </div>
          <div class="pr-4" :id="`descendant${location.id}`"></div>
        </div>
      </div>
      <!---------------------Devices----------------------->
      <div class="col-9 sm:px-6 lg:px-8">
        <div class="mx-auto bg-white shadow-xl sm:rounded-lg">
          <div v-if="loaderDevices" class="flex justify-center py-8">
            <svg
              class="w-5 h-5 mr-3 text-gray-900 animate-spin"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
            >
              <circle
                class="opacity-25"
                cx="12"
                cy="12"
                r="10"
                stroke="currentColor"
                stroke-width="4"
              ></circle>
              <path
                class="opacity-75"
                fill="currentColor"
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
              ></path>
            </svg>
          </div>
          <div v-if="!loaderDevices">
            <div v-if="devices.length == 0">
              <h3>وسیله ای وجود ندارد</h3>
            </div>
            <ul>
              <li v-for="device in devices" :key="device.id">
                {{ device.name }}
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import { defineComponent, ref } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/inertia-vue3";
import Swal from "sweetalert2";
import axios from "axios";

export default defineComponent({
  components: {
    AppLayout,
    Link,
    Swal,
  },
  props: {
    devices: Object,
    locations: Object,
    userId: Number,
  },
  data() {
    return {
      // ---------------Form Of Create Location---------------
      formLocation: this.$inertia.form({
        name: "",
        parent_id: "",
      }),

      // ----------------Form Of Create Device------------------
      formDevice: this.$inertia.form({
        name: "",
        location_id: "",
      }),

      deleteLoocation: this.$inertia.form({}),
    };
  },
  methods: {
    // -----------------Creat Loction-----------
    alertCreateLocation() {
      Swal.fire({
        title: "نام مکان را وارد کنید",
        input: "text",
        inputAttributes: {
          autocapitalize: "off",
        },
        showCancelButton: true,
        confirmButtonText: "افزودن",
        cancelButtonText: "لغو",
        showLoaderOnConfirm: true,
        confirmButtonColor: "#28a745",
        cancelButtonColor: "#6e7d88",
        preConfirm: (name) => {
          return this.sendCreatLoction(name);
        },
        allowOutsideClick: () => !Swal.isLoading(),
      });
    },
    sendCreatLoction(name) {
      this.formLocation.name = name;
      this.formLocation.post(this.route("Location.create"), {
        onError: (errors) => {
          Swal.fire({
            icon: "error",
            title: "خطاا!!!",
            text: errors.name,
            showConfirmButton: true,
            showCancelButton: true,
            cancelButtonText: "باشد",
            confirmButtonText: "برگشت",
            confirmButtonColor: "#7367f0",
            cancelButtonColor: "#6e7d88",
            preConfirm: () => {
              return this.alertCreateLocation();
            },
          });
        },
        onSuccess: () => {
          Swal.fire({
            icon: "success",
            title: "با موفقیت افزوده شد.",
            showConfirmButton: true,
            confirmButtonText: "باشد",
            confirmButtonColor: "#28a745",
          });
          this.getDescendantOf(this.formLocation.parent_id);
        },
      });
    },

    //-------------------Delete Location----------
    alertDeleteLocation(id, name) {
      Swal.fire({
        title: "توجه!",
        icon: "warning",
        text: `با حذف مکان  ${name}  تمامی زیر شاخه ها و وسایل درون آن ها حذف می شود!`,
        showCancelButton: true,
        confirmButtonText: "حذف",
        cancelButtonText: "لغو",
        showLoaderOnConfirm: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#6e7d88",
        preConfirm: () => {
          return this.sendDeleteLoction(id);
        },
      });
    },
    sendDeleteLoction(id, name) {
      this.deleteLoocation.delete(this.route("Location.delete", { id }), {
        onError: (errors) => {
          Swal.fire({
            icon: "error",
            title: "خطاا!!!",
            text: errors.name,
            showConfirmButton: true,
            showCancelButton: true,
            cancelButtonText: "باشد",
            confirmButtonText: "برگشت",
            preConfirm: () => {
              return this.alertDeleteLocation(id, name);
            },
          });
        },
        onSuccess: () => {
          Swal.fire({
            icon: "success",
            title: "با موفقیت حذف شد.",
            showConfirmButton: true,
            confirmButtonText: "باشد",
          });
          this.getOfThis(0);
        },
      });
    },
    //---------------------Hidden & Unhidden-----------------

    hiddenLocation(id) {
      let hidden = this.$inertia.form({
        id: id,
      });
      hidden.put(this.route("Location.hidden", { id: id }), {
        onSuccess: () => {
          var element = document.getElementById(`element${id}`);
          if (element.classList[1] == "fa-eye") {
            element.classList.toggle("fa-eye-slash");
            element.classList.remove("fa-eye");
          } else {
            element.classList.toggle("fa-eye");
            element.classList.remove("fa-eye-slash");
          }
        },
        onError: (errors) => {
          console.log(errors);
        },
      });
    },

    // -----------------Creat Device-----------
    alertCreateDevice() {
      Swal.fire({
        title: "نام وسیله را وارد کنید",
        input: "text",
        inputAttributes: {
          autocapitalize: "off",
        },
        showCancelButton: true,
        confirmButtonText: "افزودن",
        cancelButtonText: "لغو",
        showLoaderOnConfirm: true,
        confirmButtonColor: "#28a745",
        cancelButtonColor: "#6e7d88",
        preConfirm: (name) => {
          return this.sendCreatDevice(name);
        },
        allowOutsideClick: () => !Swal.isLoading(),
      });
    },
    sendCreatDevice(name) {
      this.formDevice.name = name;
      this.formDevice.post(this.route("Device.create"), {
        onError: (errors) => {
          Swal.fire({
            icon: "error",
            title: "خطاا!!!",
            text: errors.name,
            showConfirmButton: true,
            showCancelButton: true,
            cancelButtonText: "باشد",
            confirmButtonText: "برگشت",
            confirmButtonColor: "#7367f0",
            cancelButtonColor: "#6e7d88",
            preConfirm: () => {
              return this.alertCreateDevice();
            },
          });
        },
        onSuccess: () => {
          Swal.fire({
            icon: "success",
            title: "با موفقیت افزوده شد.",
            showConfirmButton: true,
            confirmButtonText: "باشد",
            confirmButtonColor: "#28a745",
          });
          this.getDeviceOf(this.formDevice.location_id);
        },
      });
    },
  },
  setup(props) {
    const loaderDevices = ref(false);
    let focus = ref("parent0");

    const userId = props.userId;
    const devices = ref(props.devices);
    const locations = ref();

    // ------------------Location----------------------

    let createLocation = ref(false);

    // ------------------Creat Location---------------------
    function oppenCreateLocation(id) {
      createLocation.value = true;
      this.formLocation.parent_id = id;
      this.alertCreateLocation();
    }

    // ------------------Get Descenedantof---------------------
    function getDescendantOf(id) {
      //   axios
      //     .get(`/location/show/${id}`)
      //     .then(function (response) {
      //       // handle success
      //       console.log(response.data.itemDescendant);
      //       console.log(id);
      //       let locations = response.data.itemDescendant;
      //       var a = '';
      //       for (let i = 0; i < locations.length; i++) {
      //         const element = locations[i];
      //         var show = "";
      //         if (element.hidden == 0) {
      //           var eye = "fa-eye";
      //         } else {
      //           var eye = "fa-eye-slash";
      //         }
      //         if (element.user_id == userId) {
      //           show =
      //             ` <div v-on:click="hiddenLocation(element.id)">` +
      //             `<i class="text-gray-300 fas ${eye} Pointer" id="element${element.id}"></i>` +
      //             `</div>`;
      //         }
      //         a +=
      //           `<div class="border-b-2 border-gray-200">` +
      //           `<div class="flex">` +
      //           `<div v-on:click="getOfThis(${element.id})" class="me-auto Pointer">` +
      //           `<p class="Pointer">${element.name}</p>` +
      //           `</div>` +
      //           show +
      //           `<div class="mx-2" v-on:click="oppenCreateDevice(${element.id})">` +
      //           `<i class="text-gray-300 fas fa-tshirt Pointer"></i>` +
      //           `</div>` +
      //           `<div v-on:click="oppenCreateLocation(${element.id})">` +
      //           `<i class="text-gray-300 fas fa-map-marker-alt Pointer"></i>` +
      //           `</div>` +
      //           `</div>` +
      //           `<div class="pr-4" id="descendant${element.id}"></div>` +
      //           `</div>`;
      //       }
      //       document.getElementById(`descendant${id}`).innerHTML = a;
      //     })
      //     .catch(function (error) {
      //       // handle error
      //       console.log(error);
      //     })
      //     .then(function () {
      //       // always executed
      //     });
      axios.get("/location/show").then(function (response) {
        locations.value = response.data.itemDescendant;
      });
    }
    getDescendantOf("a");
    // --------------------Device--------------------

    // -------------------Create Device ---------------
    function oppenCreateDevice(id) {
      this.formDevice.location_id = id;
      this.alertCreateDevice();
    }
    // -------------------Get Device ------------------
    function getDeviceOf(id) {
      loaderDevices.value = true;
      axios
        .get(`/device/show/${id}`)
        .then(function (response) {
          // handle success
          devices.value = response.data.devices;
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        })
        .then(function () {
          loaderDevices.value = false;
        });
    }

    function getOfThis(id) {
      document.getElementById(focus.value).classList.remove("bg-gray-100");
      document.getElementById(`parent${id}`).classList.toggle("bg-gray-100");
      getDescendantOf(id);
      getDeviceOf(id);
      focus.value = `parent${id}`;
    }
    return {
      userId,
      locations,
      devices,
      oppenCreateLocation,
      oppenCreateDevice,
      getDescendantOf,
      getDeviceOf,
      createLocation,
      getOfThis,
      loaderDevices,
    };
  },
});
</script>
