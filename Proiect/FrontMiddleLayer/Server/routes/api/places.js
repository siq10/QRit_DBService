const express = require("express");
const axios = require("axios");

const router = express.Router();

const getfromlaravel = () => {
    try {
        return axios.get('http://localhost:8000/api/places')
    } catch (error) {
        console.error(error)
    }
}
router.get('/', (req,res) => {
    getfromlaravel(req,res).then(response => {
        if(response.data)
            console.log(response.data)
        res.send(response.data);
    })
})
module.exports = router;