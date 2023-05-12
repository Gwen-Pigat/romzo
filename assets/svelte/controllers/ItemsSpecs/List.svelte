<script>
    import Icon from "../Icon.svelte";
    import FaEdit from 'svelte-icons/fa/FaEdit.svelte'
    import IoMdAddCircle from 'svelte-icons/io/IoMdAddCircle.svelte'
    import {handleState} from "../index";

    export let itemsSpecs
    export let paths = {"addItemSpec": undefined}

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
                <th scope="col">Actif</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            {#each itemsSpecs as itemSpec}
                <tr>
                    <td>{itemSpec.id}</td>
                    <td>{itemSpec.name}</td>
                    <td>{#if itemSpec.placement}{itemSpec.placement}{/if}</td>
                    <td>
                        <fieldset>
                            <label for="switch-state-{itemSpec.id}">
                                <input on:click={handleState(paths.handleItemSpecState+"?id="+itemSpec.id)} class="checkbox" type="checkbox" id="switch-state-{itemSpec.id}" name="switch-state[{itemSpec.id}}" role="switch" checked="{itemSpec.isActive}" />
                            </label>
                        </fieldset>
                    </td>
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