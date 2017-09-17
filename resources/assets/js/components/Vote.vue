<template>
    <div class="vote">
        <div class="modal-wrap" :class="{'animate-up': end}">
            <div class="divider modal-header">
                <span class="step" v-for="steps in allow.step" :key="steps" :class="{'is-active': checkStep(steps)}"></span>
            </div>
            <div class="modal-bodies">
                <transition :name="stepTrans">
                    <div class="modal-body modal-body-step-1 step" :class="{'is-showing': step===0}" v-if="step===0" :key="0">
                        <div class="title">Step {{step+1}}</div>
                        <div class="description">Hello there, Let's play a game.</div>
                        <label :for="votes" v-for="votes in allow.vote" :key="votes"> <input type="radio" :id="votes" :value="votes" v-model="vote"> {{votes}} </label>
                        <div class="text-center">
                            <div class="button" @click="next">Start</div>
                        </div>
                    </div>
                    <div class="modal-body modal-body-step-2 step" :class="{'is-showing': step===1}" v-if="step===1" :key="1">
                        <div class="title">Step {{step+1}}</div>
                        <div class="description">Would you rather</div>
                        <label :for="cat.name" v-for="cat in allow.kategori" :key="cat.id"> <input type="radio" :id="cat.name" :value="cat.id" v-model="kategori"> {{cat.name}} </label>
                        <div class="text-center fade-in">
                            <div class="button" @click="next">Next</div>
                        </div>
                    </div>
                    <div class="modal-body modal-body-step-3 human_list step" :class="{'is-showing': step===2}" v-if="step===2" :key="2">
                        <div class="title">Step {{step+1}}</div>
                        <div class="description">{{kategori}}</div>
                        <label :for="hum.name" v-for="hum in listHuman" :key="hum.id"> <input type="radio" :id="hum.name" :value="hum.id" v-model="human"> {{hum.name}} </label>
                        <div class="text-center">
                            <div class="button" @click="next">Done!</div>
                        </div>
                    </div>
                </transition>
            </div>
        </div>
        <div class="text-center">
            <div class="description rerun-button" :class="{'visible':end}" @click="reset">
                <b>Terimakasih</b>
                <p>Anda merasa puas dengan layanan CSO Ika</p>
            </div>
        </div>
    </div>
</template>

<script>
import axios from '../axios.js';

export default {
    name: "vote",
    data () {
        return {
            show: false,
            end: false,
            allow: {
                step: ['vote', 'kategori', 'human'],
                vote: ['puas', 'tidak'],
                kategori: null,
                human: null
            },
            step: 0,
            vote: null,
            kategori: null,
            human: null
        }
    },
    computed: {
        stepTrans () {
            if (this.step >= 2) {
                return 'last'
            }
            return 'init'
        },
        listHuman () {
            if (!this.allow.human) return [];
            return this.allow.human.filter((e) => {
                return e.category_id === this.kategori;
            })
        }
    },
    mounted () {
        axios.get('/api/category')
            .then(r => {
                this.allow.kategori = r.data.data
            });
        axios.get('/api/human')
            .then(r => {
                this.allow.human = r.data.data
            })
    },
    methods: {
        checkStep (step) {
            return step == this.allow.step[this.step];
        },
        reset () {
            this.step = 0;
            this.end = false;
            this.vote = null;
            this.kategori = null;
            this.human = null;
        },
        next () {
            if (this.step == 2) {
                this.end = true;
                axios.post('/api/vote', {
                    vote: this.vote,
                    category_id: this.kategori,
                    human_id: this.human
                })
                return this.step = 0
            };
            console.log(this.listHuman, this.kategori);
            this.step++;
        }
    }
}
</script>

<style lang="scss">
.init-enter-active,
.init-leave-active {
    animation: in 500ms ease-in-out forwards;
}

.init-enter,
.init-leave-to {
    animation: out 600ms ease-in-out forwards;
}


.last-enter-active,
.last-leave-active {
    animation: in 500ms ease-in-out forwards;
}

.last-enter,
.last-leave-to {
    transform: translateY(-500px) rotate(90deg);
}


html {
    background: -webkit-radial-gradient(#fff176, #f57f17);
    background: radial-gradient(#fff176, #f57f17);
    min-height: 100%;
    font-family: "Roboto", sans-serif;
}

.title {
    text-transform: uppercase;
    text-align: center;
    margin-bottom: 30px;
    color: #FF8F00;
    font-weight: 300;
    font-size: 24px;
    letter-spacing: 1px;
}

.description {
    text-align: center;
    color: #666;
    margin-bottom: 30px;
}

input[type="text"],
input[type="email"] {
    padding: 10px 20px;
    border: 1px solid #999;
    border-radius: 3px;
    display: block;
    width: 100%;
    margin-bottom: 20px;
    box-sizing: border-box;
    outline: none;
}

input[type="text"]:focus,
input[type="email"]:focus {
    border-color: #FF6F00;
}

input[type="radio"] {
    margin-right: 10px;
}

label {
    margin-bottom: 20px;
    display: block;
    font-size: 18px;
    color: #666;
    border-top: 1px solid #ddd;
    border-bottom: 1px solid #ddd;
    padding: 20px 0;
    cursor: pointer;
}

label:first-child {
    margin-bottom: 0;
    border-bottom: none;
}

.button,
.rerun-button {
    padding: 10px 20px;
    border-radius: 3px;
    background: #FF6F00;
    color: white;
    text-transform: uppercase;
    letter-spacing: 1px;
    display: inline-block;
    cursor: pointer;
}

.button:hover,
.rerun-button:hover {
    background: #e66400;
}

.button.rerun-button,
.rerun-button.rerun-button {
    border: 1px solid rgba(255, 255, 255, 0.6);
    margin-bottom: 50px;
    box-shadow: 0px 10px 15px -6px rgba(0, 0, 0, 0.2);
    display: none;
}

.text-center {
    text-align: center;
}

.modal-wrap {
    max-width: 600px;
    margin: 50px auto;
    -webkit-transition: -webkit-transform 300ms ease-in-out;
    transition: -webkit-transform 300ms ease-in-out;
    transition: transform 300ms ease-in-out;
    transition: transform 300ms ease-in-out, -webkit-transform 300ms ease-in-out;
}

.modal-header {
    height: 45px;
    background: white;
    border-bottom: 1px solid #ccc;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
}

.modal-header span {
    display: block;
    height: 12px;
    width: 12px;
    margin: 5px;
    border-radius: 50%;
    background: rgba(0, 0, 0, 0.2);
}

.modal-header span.is-active {
    background: rgba(0, 0, 0, 0.4);
    background: #FF8F00;
}

.modal-bodies {
    position: relative;
    -webkit-perspective: 1000px;
    perspective: 1000px;
}

.modal-body {
    background: white;
    padding: 40px 100px;
    box-shadow: 0px 50px 30px -30px rgba(0, 0, 0, 0.3);
    margin-bottom: 50px;
    position: absolute;
    top: 0;
    display: none;
    box-sizing: border-box;
    width: 100%;
    -webkit-transform-origin: top left;
    transform-origin: top left;
}

.modal-body.is-showing {
    display: block;
}

.animate-out {
    -webkit-animation: out 600ms ease-in-out forwards;
    animation: out 600ms ease-in-out forwards;
}

.animate-in {
    -webkit-animation: in 500ms ease-in-out forwards;
    animation: in 500ms ease-in-out forwards;
    display: block;
}

.animate-up {
    -webkit-transform: translateY(-500px) rotate(90deg);
    transform: translateY(-500px) rotate(90deg);
}

@-webkit-keyframes out {
    0% {
        -webkit-transform: translateY(0px) rotate(0deg);
        transform: translateY(0px) rotate(0deg);
    }
    60% {
        -webkit-transform: rotate(60deg);
        transform: rotate(60deg);
    }
    100% {
        -webkit-transform: translateY(800px) rotate(10deg);
        transform: translateY(800px) rotate(10deg);
    }
}

@keyframes out {
    0% {
        -webkit-transform: translateY(0px) rotate(0deg);
        transform: translateY(0px) rotate(0deg);
    }
    60% {
        -webkit-transform: rotate(60deg);
        transform: rotate(60deg);
    }
    100% {
        -webkit-transform: translateY(800px) rotate(10deg);
        transform: translateY(800px) rotate(10deg);
    }
}

@-webkit-keyframes in {
    0% {
        opacity: 0;
        -webkit-transform: rotateX(-90deg);
        transform: rotateX(-90deg);
    }
    100% {
        opacity: 1;
        -webkit-transform: rotateX(0deg);
        transform: rotateX(0deg);
    }
}

@keyframes in {
    0% {
        opacity: 0;
        -webkit-transform: rotateX(-90deg);
        transform: rotateX(-90deg);
    }
    100% {
        opacity: 1;
        -webkit-transform: rotateX(0deg);
        transform: rotateX(0deg);
    }
}








/*add by ayiphz*/

.human_list label {
    display: inline-block;
    margin: 5px;
    overflow: hidden;
    text-align: center;
    width: 120px;
}

.human_list label * {
    display: block;
}

.human_list label input {
    display: none;
}

.human_list label * {
    width: 100%;
}

.visible {
    display: inline-block!important;
}
</style>
