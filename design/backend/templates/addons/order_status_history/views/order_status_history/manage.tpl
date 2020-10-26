{capture name="mainbox"}

    <form action="{""|fn_url}" method="post" name="history_status_form" class=" cm-hide-inputs" enctype="multipart/form-data">
        <input type="hidden" name="fake" value="1" />

        {include file="common/pagination.tpl"}
        {assign var="r_url" value=$config.current_url|escape:url}

        <input type="hidden" name="return_url" value="{$config.current_url}">

        {$rev=$smarty.request.content_id|default:"pagination_contents"}
        {$page_title=__("order_status_history")}

        {if $orders}

        <div class="table-responsive-wrapper">
            <table width="100%" class="table table-middle table--relative table-responsive table-order-status-history">
            <thead>
            <tr>
                <th width="10%">{__("order_status_history.order_id")}</th>
                <th width="20%">{__("order_status_history.old_status")}</th>
                <th width="20%">{__("order_status_history.new_status")}</th>
                <th width="30%">{__("order_status_history.changed_by")}</th>
                <th width="20%">{__("order_status_history.changed_at")}</th>
            </tr>
            </thead>

            {foreach from=$orders item="o"}
            <tr>
                <td width="10%" data-th="{__("order_status_history.order_id")}">{$o.order_id}</td>
                <td width="20%" data-th="{__("order_status_history.old_status")}">{$o.old_status}</td>
                <td width="20%" data-th="{__("order_status_history.new_status")}">{$o.new_status}</td>
                <td width="30%" data-th="{__("order_status_history.changed_by")}">
                    <a href="{"profiles.update?user_id=`$o.user_id`"|fn_url}" class="underlined">{$o.user_name}</a>
                </td>
                <td width="20%" data-th="{__("order_status_history.changed_at")}">
                    {$o.timestamp|date_format:"`$settings.Appearance.date_format`, `$settings.Appearance.time_format`"}
                </td>
            </tr>
            {/foreach}
            </table>
        </div>

        {else}
            <p class="no-items">{__("no_data")}</p>
        {/if}

        {include file="common/pagination.tpl"}

    </form>

{/capture}

{include file="common/mainbox.tpl" title=__("order_status_history") content=$smarty.capture.mainbox buttons=$smarty.capture.buttons content_id="order_status_history"}
