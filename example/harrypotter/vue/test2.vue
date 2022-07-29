<template>
  <div class="test-vue">
    <h1>{{data.Title}}</h1>
    <h2>{{data.Subtitle}}</h2>
    <hr>
    
    <p>{{ currentStudent }}</p>
    <button class="circle" @click="getRandom()">Get A random Student</button>
  </div>
</template>

<script>
export default {
    name: 'Structure',
    components: {},
    data: () => ({
        data: $GLOBAL,
        currentStudent: 'Harry Potter',
        students: [
            'Harry Potter',
            'Hermione Granger',
            'Ron Weasley',
            'Neville Longbottom',
            'Draco Malfoy',
            'Severus Snape',
            'Albus Dumbledore',
            'Minerva McGonagall',
            'Sirius Black',
            'Rubeus Hagrid',
            'Voldemort',
            'Dobby',
            'Molly Weasley',
            'Luna Lovegood',
            'Cedric Diggory',
            'Cho Chang',
            'Gregory Goyle',
            'Bellatrix Lestrange',
            'Argus Filch',
            'Padma Patil',
            'Lucius Malfoy',
            'Narcissa Malfoy'
        ]
    }),
    setup() {
    },
    beforeCreate() {
    },
    created() {
    },
    beforeMount() {
    },
    mounted() {
    },
    beforeUpdate() {
    },
    updated() {
    },
    beforeUnmount() {
    },
    unmounted() {
    },
    computed: {
    },
    methods: {
        getRandom(){
            this.currentStudent = this.students[Math.floor(Math.random() * this.students.length)];
        }
    }
}
</script>


<style lang="css">
.circle {
    border: 5px solid #000;
    margin: auto;
}
.dark .circle {
    background: #fff;
}
.light .circle {
    background: #333;
}
.orange .circle {
    background: #ff0000;
}
</style>