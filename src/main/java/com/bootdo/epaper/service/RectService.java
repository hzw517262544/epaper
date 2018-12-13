package com.bootdo.epaper.service;

import com.bootdo.epaper.domain.RectDO;

import java.util.List;
import java.util.Map;

/**
 * 
 * 
 * @author hzw
 * @email hao17681124518@163.com
 * @date 2018-12-12 18:40:04
 */
public interface RectService {
	
	RectDO get(Integer id);
	
	List<RectDO> list(Map<String, Object> map);
	
	int count(Map<String, Object> map);
	
	int save(RectDO rect);
	
	int update(RectDO rect);
	
	int remove(Integer id);
	
	int batchRemove(Integer[] ids);

	int removeByPublisId(Integer publishid);
}
