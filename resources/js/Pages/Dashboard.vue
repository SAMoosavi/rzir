<template>
  <!---------------------Heder-------------------->
  <app-layout title="وسایل">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">وسایل</h2>
    </template>

    <div class="py-12 row g-2">
      <!---------------------Locations------------------->
      <div class="p-4 mr-4 bg-white shadow-xl col-2 sm:rounded-lg">
        <div>
          <div @click="oppenCreateLocation(null)">
            <i
              class="text-gray-300 fas fa-map-marker-alt"
              style="cursor: Pointer"
            ></i>
          </div>
        </div>
        <div
          v-for="(location, key) in locations"
          :key="key"
          class="flex border-b-2 border-gray-200"
        >
          <div
            @click="getOfThis(location.id)"
            class="me-auto"
            style="cursor: Pointer"
          >
            <p style="cursor: Pointer">{{ location.name }}</p>
          </div>
          <div
            v-if="location.user_id == userId"
            @click="hiddenLocation(location.id, key)"
          >
            <div v-if="location.hidden == 0">
              <i
                class="text-gray-300 fas fa-eye"
                :id="`element${location.id}`"
                style="cursor: Pointer"
              ></i>
            </div>
            <div v-if="location.hidden == 1">
              <i
                :id="`element${location.id}`"
                class="text-gray-300 fas fa-eye-slash"
                style="cursor: Pointer"
              ></i>
            </div>
          </div>
          <div class="mx-2" @click="oppenCreateDevice(location.id)">
            <i
              class="text-gray-300 fas fa-shopping-basket"
              style="cursor: Pointer"
            ></i>
          </div>
          <div @click="oppenCreateLocation(location.id)">
            <i
              class="text-gray-300 fas fa-map-marker-alt"
              style="cursor: Pointer"
            ></i>
          </div>
          <div :id="location.id"></div>
        </div>
      </div>

      <!---------------------Devices----------------------->
      <div class="col-9 sm:px-6 lg:px-8">
        <div class="mx-auto bg-white shadow-xl sm:rounded-lg">
          <ul>
            <li v-for="device in devices" :key="device.id">
              {{ device.name }}
            </li>
          </ul>
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
      locations: {},
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
          });
          this.getDescendantOf(this.formLocation.parent_id);
        },
      });
    },

    //---------------------Hidden & Unhidden-----------------

    hiddenLocation(id, key) {
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
          });
          this.getDeviceOf(this.formDevice.location_id);
        },
      });
    },
  },
  setup(props) {
    const userId = props.userId;
    const devices = ref(props.devices);
    const locations = ref(props.locations);

    // ------------------Location----------------------

    let createLocation = ref(false);
    let showId = ref(null);

    // ------------------Creat Location---------------------
    function oppenCreateLocation(id) {
      createLocation.value = true;
      this.formLocation.parent_id = id;
      this.alertCreateLocation();
    }

    // ------------------Get Descenedantof---------------------
    function getDescendantOf(id) {
      showId.value = id;
      axios
        .get(`/location/show/${id}`)
        .then(function (response) {
          // handle success
          console.log(response);
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        })
        .then(function () {
          // always executed
        });
    }

    // --------------------Device--------------------

    // -------------------Create Device ---------------
    function oppenCreateDevice(id) {
      this.formDevice.location_id = id;
      this.alertCreateDevice();
    }
    // -------------------Get Device ------------------
    function getDeviceOf(id) {
      axios
        .get(`/device/show/${id}`)
        .then(function (response) {
          // handle success
          console.log("device:", response.data);
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        })
        .then(function () {
          // always executed
        });
    }

    function getOfThis(id) {
      getDescendantOf(id);
      getDeviceOf(id);
    }
    return {
      userId,
      locations,
      oppenCreateLocation,
      oppenCreateDevice,
      getDescendantOf,
      getDeviceOf,
      createLocation,
      showId,
      getOfThis,
    };
  },
});
</script>





//کخفی کردن چجور نمایش بدم؟

