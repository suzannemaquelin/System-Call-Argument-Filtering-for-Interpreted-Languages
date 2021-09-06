<?php

$values = Array(
'example.com',
'www.thelongestdomainnameintheworldandthensomeandthensomemoreandmore.com',
'toolongtoolongtoolongtoolongtoolongtoolongtoolongtoolongtoolongtoolong.com',
'eauBcFReEmjLcoZwI0RuONNnwU4H9r151juCaqTI5VeIP5jcYIqhx1lh5vV00l2rTs6y7hOp7rYw42QZiq6VIzjcYrRm8gFRMk9U9Wi1grL8Mr5kLVloYLthHgyA94QK3SaXCATklxgo6XvcbXIqAGG7U0KxTr8hJJU1p2ZQ2mXHmp4DhYP8N9SRuEKzaCPcSIcW7uj21jZqBigsLsNAXEzU8SPXZjmVQVtwQATPWeWyGW4GuJhjP4Q8o0.com',
'kDTvHt1PPDgX5EiP2MwiXjcoWNOhhTuOVAUWJ3TmpBYCC9QoJV114LMYrV3Zl58.kDTvHt1PPDgX5EiP2MwiXjcoWNOhhTuOVAUWJ3TmpBYCC9QoJV114LMYrV3Zl58.kDTvHt1PPDgX5EiP2MwiXjcoWNOhhTuOVAUWJ3TmpBYCC9QoJV114LMYrV3Zl58.CQ1oT5Uq3jJt6Uhy3VH9u3Gi5YhfZCvZVKgLlaXNFhVKB1zJxvunR7SJa.com.',
'cont-ains.h-yph-en-s.com',
'..com',
'ab..cc.dd',
'a.-bc.com',
'ab.cd-.com',
'-.abc.com',
'abc.-.abc.com',
'underscore_.example.com',
'',
-1,
array(),
'\r\n',
);
foreach ($values as $value) {
	var_dump(filter_var($value, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME));
}

var_dump(filter_var('_example.com', FILTER_VALIDATE_DOMAIN));
var_dump(filter_var('_example.com', FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME));
var_dump(filter_var('test_.example.com', FILTER_VALIDATE_DOMAIN));
var_dump(filter_var('test_.example.com', FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME));
var_dump(filter_var('te_st.example.com', FILTER_VALIDATE_DOMAIN));
var_dump(filter_var('te_st.example.com', FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME));
var_dump(filter_var('test._example.com', FILTER_VALIDATE_DOMAIN));
var_dump(filter_var('test._example.com', FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME));

echo "Done\n";
?>
