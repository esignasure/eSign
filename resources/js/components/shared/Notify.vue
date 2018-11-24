<script>
    export default {
        name: "notify",
        methods: {
            convertToList: function (message) { // convert array into the list
                if (message instanceof Array) {

                    let list = `<ul>`;
                    message.forEach(element => {
                        if (element instanceof Object) {  // IF ITEM IS OBJECT - GET VALUE.
                        const errorMessage = element[Object.keys(element)[0]];
                        list += `<li>${errorMessage}</li>`;
                    } else {                          // SET STRING ITEM AS MESSAGE.
                        list += `<li>${element}</li>`;
                    }
                });
                    list += `</ul>`;
                    return list;

                } else if (message instanceof Object) { // IF ITEM IS OBJECT - GET VALUE.

                    let list = `<ul>`;
                    Object.keys(message).forEach(element => {
                        const messageString = message[element];
                    list += `<li>${messageString}</li>`;
                });
                    list += `</ul>`;
                    return list;

                } else { // IF MESSAGE IS SINGLE STRING.
                    return message;
                }
            },

            /**
             * notification for success or
             * display success message
             **/
            notifySuccess: function (message) { // success notification
                const notifyMessage = this.convertToList(message);
                Vue.notify({
                    type: 'success',
                    title: 'Success!',
                    text: notifyMessage,
                    duration: 3000
                });
            },
            /**
             * display nitification for error or
             * display error messsage
             **/
            notifyError: function (message) { // error notification
                const notifyMessage = this.convertToList(message);
                Vue.notify({
                    type: 'error',
                    title: 'Error!',
                    text: notifyMessage,
                    duration: 3000
                });
            }

        }/** END OF METHOD SECTION **/
    }
</script>
