<div class="fullScreen">
    <div class="inputBox">
        <form method="get" action="/search">
            <label>
                <input type="text" placeholder="Search here...">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"> <br>
            </label>
            <button type="submit">
                <i class="fas fa-arrow-right"></i>
            </button>
        </form>
    </div>
</div>
