<div class="row single-price">

    <div class="col-12">
        <div class="row">
            @foreach ($attributeGroups as $attributeGroup)
                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label>{{ $attributeGroup->name }}</label>
                        <select class="form-control price-attribute-select"
                                name="prices[{{ $loop->parent->iteration }}][attributes][]">
                            <option value="">انتخاب کنید</option>
                            @foreach ($attributeGroup->get_attributes as $attribute)
                                <option
                                    value="{{ $attribute->id }}" {{ $price->get_attributes()->find($attribute->id) ? 'selected' : '' }}>{{ $attribute->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="col-md-3 col-12">
        <div class="form-group">
            <label>قیمت</label>
            <input type="number" data-unit="{{currencyTitle()}}" class="form-control amount-input price"
                   name="prices[{{ $loop->iteration }}][price]" value="{{ $price->price() }}" required>
        </div>
    </div>

    <div class="col-md-3 col-12">
        <div class="form-group">
            <label>تخفیف</label>
            <input type="number" class="form-control discount" name="prices[{{ $loop->iteration }}][discount]"
                   value="{{ $price->discount }}" min="0" max="100" placeholder="%">
        </div>
    </div>

    <div class="col-md-3 col-12">
        <div class="form-group">
            <label>بیشترین تعداد مجاز در هر سفارش</label>
            <input type="number" class="form-control" name="prices[{{ $loop->iteration }}][cart_max]"
                   value="{{ $price->cart_max }}" min="1">
        </div>
    </div>
    <div class="col-md-3 col-12">
        <div class="form-group">
            <label>کمترین تعداد مجاز در هر سفارش</label>
            <input type="number" class="form-control" name="prices[{{ $loop->iteration }}][cart_min]"
                   value="{{ $price->cart_min }}" min="1">
        </div>
    </div>
    <div class=" row col-12" id="discountField">
        @php
        $iteration = $loop->iteration ;
        @endphp
        @foreach($price->discountMajors as $key =>$discount)
            <div class="col-md-4 col-12">
                <div class="form-group">
                    <label>قیمت  عمده</label>
                    <input type="number" data-unit="{{currencyTitle()}}" class="form-control amount-input price"
                           name="prices[{{ $iteration }}][discount_major][{{$key}}]"
                           value="{{ $discount->discount }}"  placeholder="قیمت عمده">
                </div>
            </div>
            <div class="col-md-4 col-12">

                <div class="form-group">
                    <label>کمترین تعداد</label>
                    <input type="number" class="form-control" name="prices[{{ $iteration }}][min][{{$key}}]"
                           value="{{ $discount->min }}" min="0">
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="form-group">
                    <label>بیشترین تعداد</label>
                    <input type="number" class="form-control" name="prices[{{ $iteration }}][max][{{$key}}]"
                           value="{{ $discount->max }}" min="0">
                </div>
            </div>
        @endforeach
        @for($i = count($price->discountMajors) ; $i < 4 ; $i++)
            <div class="col-md-4 col-12">
                <div class="form-group">
                    <label>قیمت عمده</label>
                    <input type="number" data-unit="{{currencyTitle()}}" class="form-control amount-input price"
                           name="prices[{{ $loop->iteration }}][discount_major][{{$i}}]" value=""
                           placeholder="قیمت عمده">
                </div>
            </div>
            <div class="col-md-4 col-12">

                <div class="form-group">
                    <label>کمترین تعداد</label>
                    <input type="number" class="form-control" name="prices[{{ $loop->iteration }}][min][{{$i}}]"
                           value="" min="0">
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="form-group">
                    <label>بیشترین تعداد</label>
                    <input type="number" class="form-control" name="prices[{{ $loop->iteration }}][max][{{$i}}]"
                           value="" min="0">
                </div>
            </div>
        @endfor

    </div>

    <div class="col-md-3 col-12">
        <div class="form-group">
            <label>موجودی انبار</label>
            <input type="number" class="form-control" name="prices[{{ $loop->iteration }}][stock]"
                   value="{{ $price->stock }}" min="0" required>
        </div>
    </div>
    <div class="col-md-3 col-12">
        <div class="form-group">
            <label>قیمت نهایی</label>
            <input type="text" class="form-control final-price" disabled>
        </div>
    </div>

    <div class="col-md-3 col-12">
        <div class="form-group">
            <label>تایپ قیمت</label>
            <select name="prices[{{ $loop->iteration }}][title]" class="form-control">
                <option value="">انتخاب کنید</option>
                @for($i=1;$i<=10;$i++)
                    <option value="fldTipFee{{$i}}" {{ $price->title=="fldTipFee".$i ? 'selected' : '' }}>
                        @if("fldTipFee".$i=="fldTipFee1")
                            fldTipFee{{$i}} (قیمت اصلی)
                        @elseif("fldTipFee".$i=="fldTipFee2")
                            fldTipFee{{$i}} (تخفیف ها)

                        @else
                            fldTipFee{{$i}}
                        @endif
                    </option>
                @endfor
            </select>
        </div>
    </div>

    <div class="col-md-12">
        <button type="button" class="btn btn-flat-danger waves-effect waves-light remove-product-price custom-padding">
            حذف</i></button>
    </div>

    <div class="col-md-12">
        <hr>
    </div>
</div>
