angular.module('mailTree')
.factory('HelperSvc', ['$http', '$sanitize', function(HelperSvc, $http, $sanitize) {

   return {

    /**
     * Turn associative array to an array.
     * @param  {[type]} object [description]
     * @return {[type]}        [description]
     */
    associative_to_array: function(object) {
      var array = [];
      for(var item in object){
        if(object[item].hasOwnProperty('keyword')) {
          array.push(object[item].keyword);
        } else {
          array.push(object[item]);
        }
      }
      return array;
    },

    /**
     * Oposite of associative_to_array.
     * @param  {[type]} array [description]
     * @return {[type]}       [description]
     */
    array_to_associative: function(array) {
      var obj = {};
      for(var i = 0; i < array.length; i++) {
          obj[i] = array[i];    // Assign the next element as a value of the object,
                                   // using the current value as key
      }
      return obj;
    },

    /**
     * Stringify the object/associative array.
     * @param  {[type]} object [description]
     * @return {[type]}        [description]
     */
    array_stringify: function(object) {
      return JSON.stringify(object);
    },

    /**
     * Validate email.
     * @param  {[type]} email [description]
     * @return {[type]}       [description]
     */
    validateEmail: function(email) {
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    },

    /**
     * Find multiple indexes in array
     * @param  {[type]} array  [description]
     * @param  {[type]} values [description]
     * @return {[type]}        [description]
     */
    findMulIndexinArr: function(array, values) {
      var indexs = [];

      if(typeof values == 'object') {
        values = this.associative_to_array(values);
      }

      if(typeof values == 'string') {
        values.push(values);
      }

      for (var i = array.length - 1; i >= 0; i--) {
        for (var j = values.length - 1; j >= 0; j--) {
          if(array[i] == values[j]) {
            indexs.push(i);
          };
        };
      };
      
      return indexs;
    },

    /**
     * Find element in array.
     * @param  {[type]} array [description]
     * @param  {[type]} value [description]
     * @return {[type]}       [description]
     */
    findInArr: function(array, value) {
      for (var i = array.length - 1; i >= 0; i--) {
        if(array[i] == value) {
          return i;
        }
      }
      return -1;
    },

    /**
     * Find the elment by attribute value.
     * @param  {[type]} array [description]
     * @param  {[type]} attr  [description]
     * @param  {[type]} value [description]
     * @return {[type]}       [description]
     */
    findIntemInArr: function(array, attr, value) {
      for(var i = 0; i < array.length; i++) {
        if(array[i][attr] == value) {
          return array[i];
        }
      }
    },

    /**
     * Find object by it's attribute value.
     * @param  {[type]} array [description]
     * @param  {[type]} attr  [description]
     * @param  {[type]} value [description]
     * @return {[type]}       [description]
     */
    findIndexWithAttr: function(array, attr, value) {
      for(var i = 0; i < array.length; i += 1) {
        if(array[i][attr] == value) {
            return i;
        }
      }
      return -1;
    }

  };

}]);
