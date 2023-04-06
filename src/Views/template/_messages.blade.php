<div>

    @if (isset($errors))

        @if (0 < $errors->count())

            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" title="Close"
                        data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <strong>Whoops!</strong> Something went wrong.
            </div>

        @endif

    @endif

    @if (isset($warnings))

        @if (is_array($warnings) && count($warnings))

            <div class="alert alert-warning" role="alert">
                <button type="button" class="close" title="Close"
                        data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <div>
                    <strong>Warning</strong>
                </div>
            </div>

        @endif

    @endif

    @if (session('danger'))

    <div class="alert alert-danger" role="alert">
        <button type="button" class="close" title="Close"
                data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        {{ session('danger')}}
    </div>

    @endif

    @if (session('warning'))

    <div class="alert alert-warning" role="alert">
        <button type="button" class="close" title="Close"
                data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        {{ session('warning')}}
    </div>

    @endif

    @if (session('success'))

    <div class="alert alert-success" role="alert">
        <button type="button" class="close" title="Close"
                data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        {{ session('success') }}
    </div>

    @endif

    @if (session('status'))

    <div class="alert alert-success" role="alert">
        <button type="button" class="close" title="Close"
                data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        {{ session('status') }}
    </div>

    @endif

</div>
