<form action="POST" class="form-class" id='form'>

    <input type="text" name='name' placeholder="name">
    <input type="email" name='email' placeholder="email">
    <input type="password" name='password' placeholder="password">
    <textarea type="textarea" name='textarea' placeholder="textarea"></textarea>

    <button type='submit'>Submit</button>

</form>

<script>
    const form = document.getElementById('form');

    form.addEventListener('submit',async(event)=>{
        event.preventDefault();

        const formData = new FormData(form);
        const data = {};
        formData.forEach((value, key) => {
            data[key] = value;
        });

            try {
                const response = await fetch('<?php echo esc_url(get_rest_url(null, 'v1/form-contact/submit')); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-WP-Nonce': '<?php echo wp_create_nonce('wp_rest'); ?>'
                    },
                    body: JSON.stringify(data)
                });

                if(!response.ok) throw new Error('Errow while posting the data');

                const result = await response.json();
                console.log(result);

            } catch (error) {
                console.error(error);
            }
        })
</script>

<style>
    .form-class{
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 450px;
        margin:0px auto;
    }

    input{
        margin:2em;
        padding:1.2em;
        border-radius: 1.2em;
    }

    textarea{
        margin:2em;
        padding:1.2em;
        border-radius: 1.2em;
    }

    button{
        padding:1em;
        border-radius: 1.2em;
        width: 75%;
    }
</style>

