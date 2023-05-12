<script>

    import FaRegSave from 'svelte-icons/fa/FaRegSave.svelte'
    import IoIosArrowDropleftCircle from 'svelte-icons/io/IoIosArrowDropleftCircle.svelte'
    import Icon from "../Icon.svelte";

    export let fields
    export let item

    export let itemsSpecs
    export let path
    export let pathList
    export let title

    let error = null
    let success = null

    async function handleSubmit(event){
        const data = new FormData(this)

        const btnSubmit = document.getElementById(event.currentTarget.getAttribute("data-submit"))
        if(btnSubmit){
            //btnSubmit.setAttribute("aria-busy","true")
        }

        const response = await fetch(event.currentTarget.getAttribute("data-path"), {
            method: 'POST',
            body: data
        });
        const result = await response.json();

        if(result.data.error){
            error = result.data.error
            btnSubmit.removeAttribute("aria-busy")
        }
        if(result.data.url){
            let timer = 0
            if(result.data.url.timer){
                timer = result.data.url.timer
            }
            setTimeout(function(){
                window.location.href = result.data.url.value
            },timer);
        }
    }
    $: {
        error;
        console.log(error)
    }

</script>

<h1>{title}</h1>
{#if success !== null}
    <div class="success">{success}</div>
{:else}
    <form on:submit|preventDefault={handleSubmit} data-path="{path}" data-submit="setItemBtn">
        <div class="col-items">
            <h2>Informations générales</h2>
            {#if item.image}
                <p>Image actuelle choisie :</p>
                <img src="{item.image}" alt="{item.name}" />
            {/if}
            {#if !fields}
                AUcun champ n'a pu être récupéré
            {/if}
            {#each fields as field}
                {@html field}
            {/each}
        </div>
        {#if itemsSpecs}
            <div class="col-items-specs">
                <h2>Renseigner les specs techniques</h2>
                {#each itemsSpecs as itemSpec}
                    <label for="item-spec-{itemSpec.id}">{itemSpec.name}</label>
                    <select id="item-spec-{itemSpec.id}" name="items_specs[{itemSpec.id}]">
                        <option value="0">- - -</option>
                        {#each {length: 5} as _, i}
                            {#if item.itemsSpecsItems && item.itemsSpecsItems[itemSpec.id] && item.itemsSpecsItems[itemSpec.id] === (i+1)}
                                <option selected="selected">{i+1}</option>
                            {:else}
                                <option>{i+1}</option>
                            {/if}
                        {/each}
                    </select>
                {/each}
            </div>
        {/if}
        <div class="grid">
            <a href="{pathList}" class="primary" role="button">
                <Icon color="#fff"><IoIosArrowDropleftCircle /></Icon> Retour à la liste
            </a>
            <button id="setItemBtn" class="contrast" type="submit">
                <Icon><FaRegSave /></Icon> Ajouter l'item
            </button>
        </div>
        {#if error !== null}
            <div class="error">{error}</div>
        {/if}
    </form>
{/if}

<style>
    .grid{
        margin-top: 2rem;
        clear: both;
    }
    .col-items img{
        margin-bottom: 1rem;
    }
    .col-items-specs{
        margin-top: 1rem;
    }
    #setItemBtn{
        margin: 0;
    }
</style>