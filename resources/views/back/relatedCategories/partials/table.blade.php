@foreach ($categories as $category)
    <tr>
        <td>
            <div class="vs-checkbox-con vs-checkbox-primary">
                <input type="checkbox" class="toggle-active"
                       data-id="{{ $category->id }}"
                    {{ $category->hasActiveRelatedSuggestions() ? 'checked' : '' }}>
                <span class="vs-checkbox">
                    <span class="vs-checkbox--check"><i class="feather icon-check"></i></span>
                </span>
            </div>
        </td>
        <td>
            <strong>({{ $category->id }})</strong> {{ $category->full_title }}
        </td>
        <td>
            <select class="form-control select2-suggested"
                    data-category-id="{{ $category->id }}"
                    multiple="multiple"
                    style="width: 100%;">
                @foreach($categories as $related)
                    @if($related->id === $category->id) @continue @endif
                    <option value="{{ $related->id }}"
                        {{ in_array($related->id, $category->getSuggestedCategoryIds()) ? 'selected' : '' }}>
                        {{ $related->title }}
                    </option>
                @endforeach
            </select>
        </td>
        <td class="text-center">
            <button type="button"
                    class="btn btn-sm btn-primary save-btn"
                    data-category-id="{{ $category->id }}"
                    data-loading="<span class='spinner-border spinner-border-sm'></span> درحال ذخیره سازی ...">
                ذخیره
            </button>
        </td>
    </tr>
@endforeach
