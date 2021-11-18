<template>
  <div class="items-center h-screen p-0 m-0 row">
    <!-- Form -->
    <div
      class="flex self-center pt-6 md:flex-col mirn-h-screen sm:justify-center sm:pt-0 col-12 col-md-5 "
    >
      <div
        class="w-full px-6 py-4 mt-6 ml-0 mr-0 overflow-hidden bg-gray-100 shadow-md md:mr-4 sm:max-w-md sm:rounded-lg"
      >
        <slot />
      </div>
    </div>
    <!-- Image -->
    <div class="hidden p-0 m-0 ml-8 col-6 md:inline-block justify-self-center">
      <slot name="image" />
    </div>
  </div>
</template>
