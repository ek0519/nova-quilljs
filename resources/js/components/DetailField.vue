<template>
    <panel-item :field="field" >
        <template slot="value">
            <excerpt :content="field.value" :should-show="field.shouldShow" />
        </template>
    </panel-item>
</template>

<script>
export default {
    props: ['resource', 'resourceName', 'resourceId', 'field'],
}
</script>

<style>
.ql-video{
  width: 800px;
  height: 450px;
}
  
</style>