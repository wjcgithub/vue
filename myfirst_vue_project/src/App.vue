<template>
  <div id="app">
    <h1 v-html="title"></h1>
    <ul>
      <li v-for="item in items" v-bind:class="{finished: item.isFinished}">
        {{item.label}}
      </li>
    </ul>
  </div>
</template>

<script>
// import Hello from './components/Hello'

export default {
  name: 'app',
  data () {
    return {
      title: '<span>span</span>this is title',
      finished: 'finished',
      items: [
        {
          label: 'coding',
          isFinished: false
        },
        {
          label: 'walking',
          isFinished: true
        }
      ]
    }
  }
}
</script>

<style>
.finished{
  text-decoration: underline;
}
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
