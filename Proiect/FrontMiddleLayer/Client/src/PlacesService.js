import axios from "axios";

const url = 'api/places';

class PlacesService {
    static getPlaces() {
        return new Promise(async (resolve,reject) => {
            try {
                const res = await axios.get(url);
                const data = res.data;
                resolve(data);

            }
            catch(err) {
                reject(err)
            }
        })
    }
}

export default PlacesService