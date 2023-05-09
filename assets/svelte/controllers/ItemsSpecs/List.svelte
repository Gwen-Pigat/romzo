<script>
    import Icon from "../Icon.svelte";
    import FaEdit from 'svelte-icons/fa/FaEdit.svelte'
    import IoMdAddCircle from 'svelte-icons/io/IoMdAddCircle.svelte'

    export let itemsSpecs
    export let paths = {"addItemSpec": undefined}
    async function handleState(path){

    }

</script>

<a href="{paths.addItemSpec}" role="button" class="contrast outline add_item">
    <Icon color="#fff"><IoMdAddCircle /></Icon> Ajouter une spec
</a>
{#if itemsSpecs}
    <h2>Liste des spécifités techniques</h2>
    <div class="grid">
        <table>
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nom</th>
                <th scope="col">Ordre</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            {#each itemsSpecs as itemSpec}
                <tr>
                    <td>{itemSpec.id}</td>
                    <td>{itemSpec.name}</td>
                    <td>{itemSpec.placement}</td>
                    <td>
                        <a href="{paths.addItemSpec}/{itemSpec.id}" role="button" class="contrast outline sm">
                            <Icon color="#fff" w="15" h="15"><FaEdit /></Icon>
                        </a>
                    </td>
                </tr>
            {/each}
            </tbody>
        </table>
    </div>
{/if}

<style>
    h2{
        margin-bottom: 1rem;
    }
    .add_item{
        float: right;
    }
    .checkbox{
        margin-top: 1rem;
    }
</style>