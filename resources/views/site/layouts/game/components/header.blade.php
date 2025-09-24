<div class="container" id="game-header">
    <div class="row">
        <div class="col-12">
            @include('site.game.components.share')
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div id="game-header-left">
                @include('site.game.components.cover')
                @include('site.game.components.buttons')
                <div class="clearfix"></div>
            </div>
            <div id="game-header-right">
                @include('site.game.components.tags')
                @include('site.game.components.name')
                @include('site.game.components.scores')
            </div>
        </div>
    </div>
</div>