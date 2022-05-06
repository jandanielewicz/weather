

    // Mock endpoints to be changed with actual REST API implementation
let wthrAPI = {
    getWeatherTodayEndpoint() {
        return '/api/weather/today/'
    },
    getCarEndpoint(id) {
        return '/api/mock-get-car' + '/' + id;
    },

    deleteCarEndpoint(id) {
        return '/api/mock-delete-car' + '/' + id;
    },
    getTripsEndpoint() {
        return '/api/mock-get-trips';
    },
    getProfileEndpoint() {
        return '/api/user';
    },
    editProfileEndpoint() {
        return 'api/save-profile'
    },
    deleteProfileEndpoint() {
        return 'api/delete-profile'
    },
    getCarsEndpoint() {
        return '/api/user';
    },
}



export { wthrAPI };
